<?php declare(strict_types=1);

namespace Builder\Tests;

use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FacadeTest extends TestCase
{
    /**
     * @throws Exception
     */
    #[DataProvider('provideBuildQuery')]
    function testBuildQuery(string $expected, string $skip, string $query,  array $args = [])
    {
        $this->assertEquals($expected, buildQuery($query, $skip, $args));
    }

    public static function provideBuildQuery() : array
    {
        return[
            ["", "|", ""],
            ["SELECT name FROM users WHERE user_id = 1", "|", "SELECT name FROM users WHERE user_id = 1"],
            ['SELECT * FROM users WHERE name = \'Jack\' AND block = 0', "|", "SELECT * FROM users WHERE name = ? AND block = 0", ['Jack']],
            ["SELECT `name`, `email` FROM users WHERE user_id = 2 AND block = 1", "|", "SELECT ?# FROM users WHERE user_id = ?d AND block = ?d", [['name', 'email'], 2, true]],
            ['UPDATE users SET `name` = \'Jack\', `email` = NULL WHERE user_id = -1', "|", "UPDATE users SET ?a WHERE user_id = -1", [['name' => 'Jack', 'email' => null]]],
            ['SELECT name FROM users WHERE `user_id` IN (1, 2, 3)', "|", 'SELECT name FROM users WHERE ?# IN (?a){ AND block = ?d}', ['user_id', [1, 2, 3], "|"]],
            ['SELECT name FROM users WHERE `user_id` IN (1, 2, 3) AND block = 1', "|", 'SELECT name FROM users WHERE ?# IN (?a){ AND block = ?d}', ['user_id', [1, 2, 3], true]],
            ['SELECT |', "|", 'SELECT |', []],
            ['SELECT \'|\'', "|", 'SELECT ?', ["|"]],
            ['SELECT |  from not skip 1', "|", 'SELECT | { skip ?} from {not skip ?d}', ["|", 1]],
        ];
    }
}