<?php

namespace App\Core;

use PDO;

class Database
{
    public PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once Application::$ROOT_DIR . '/migrations/' . $migration;

            $class = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $class;

            $this->log("Applying migration $class");
            $instance->up();
            $this->log("Applied migration $class");

            $newMigrations[] = $migration;
        }

        if (empty($newMigrations)) {
            $this->log("Nothing to migrate");
            return;
        };

        $this->saveMigrations($newMigrations);
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    public function createMigrationsTable()
    {
        $statement = "CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;";

        $this->pdo->exec($statement);
    }

    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare('SELECT migration FROM migrations;');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $str = implode(', ', array_map(fn ($m) => "('$m')", $migrations));
        $sql = "INSERT INTO migrations(migration) VALUES $str";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
    }

    protected function log(string $message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}
