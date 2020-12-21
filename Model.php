<?php
/**
 * Created by Alex Negoita
 * IDE: PHP Storm
 * Date: 6/19/2019
 * Time: 7:40 PM
 * PHP Version 7
 */

namespace rpa\erektorcore;


class Model extends Database
{
    public array $errors = [];


    public function __construct($config)
    {
        parent::__construct($config);
    }


    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }


    public function tableName(): string
    {
        return 'migrations';
    }


    public function validate(): bool
    {
        return empty($this->errors) ?? false;
    }







    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(dirname(__DIR__).'/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..' ) {
                continue;
            }

            require_once dirname(__DIR__).'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className;
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations applied");
        }
    }


    public function createMigrationsTable()
    {
        parent::getDB()->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
            ) ENGINE=INNODB;");
    }


    public function getAppliedMigrations()
    {
        $statement = parent::getDB()->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }


    public function saveMigrations(array $migrations)
    {
        $str = implode(",", array_map(fn($m)=> "('$m')", $migrations));

        $statement = parent::getDB()->prepare("INSERT INTO migrations (migration) VALUES 
            $str
        ");
        $statement->execute();
    }


    protected function log($message)
    {
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }


    public function prepare($sql)
    {
        return parent::getDB()->prepare($sql);
    }


}