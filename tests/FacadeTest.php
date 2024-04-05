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
            # Тестовое задание. Написать функцию формирования sql-запросов (MySQL) из шаблона и значений параметров.
            ["SELECT name FROM users WHERE user_id = 1", "|", "SELECT name FROM users WHERE user_id = 1"],
            # Места вставки значений в шаблон помечаются вопросительным знаком,
            ["SELECT name FROM users WHERE user_id = 1", "|", "SELECT name FROM users WHERE user_id = ?", [1]],
            # , после которого может следовать спецификатор преобразования.
            # Спецификаторы:
            # ?d - конвертация в целое число
            ["SELECT name FROM users WHERE user_id = 1", "|", "SELECT name FROM users WHERE user_id = ?d", [1]],
            # ?f - конвертация в число с плавающей точкой
            ['SELECT * FROM users WHERE name = 1.100000 AND block = 0', "|", 'SELECT * FROM users WHERE name = ?f AND block = 0', [1.1]],
            # ?a - массив значений
            ['SELECT name FROM users WHERE name IN (1, 2, 3)', "|", 'SELECT name FROM users WHERE name IN (?a)', [[1,2,3]]],
            # ?# - идентификатор или массив идентификаторов
            ["SELECT `name`, `email` FROM users", "|", "SELECT ?# FROM users", [['name', 'email']]],
            # Если спецификатор не указан, то используется тип переданного значения,
            # но допускаются только типы string,
            ["SELECT name FROM users WHERE user_id = '1'", "|", "SELECT name FROM users WHERE user_id = ?", ['1']],
            # int
            ["SELECT name FROM users WHERE user_id = 1", "|", "SELECT name FROM users WHERE user_id = ?", [1]],
            # float
            ["SELECT name FROM users WHERE user_id = 1.100000", "|", "SELECT name FROM users WHERE user_id = ?", [1.1]],
            # bool (приводится к 0 или 1)
            ["SELECT name FROM users WHERE user_id = 0", "|", "SELECT name FROM users WHERE user_id = ?", [false]],
            # и null.
            ["SELECT name FROM users WHERE user_id = NULL", "|", "SELECT name FROM users WHERE user_id = ?", [null]],
            # Параметры ?, ?d, ?f могут принимать значения null (в этом случае в шаблон вставляется NULL).
            ["SELECT name FROM users WHERE user_id = NULL and age = NULL and salary = NULL", "|", "SELECT name FROM users WHERE user_id = ? and age = ?d and salary = ?f", [null, null, null]],
            # Строки и идентификаторы автоматически экранируются.
            ["SELECT `name` FROM users where surname = 'test'", "|", "SELECT ?# FROM users where surname = ?", ['name', 'test']],
            # Массив (параметр ?a) преобразуется либо в список значений через запятую (список),
            ['SELECT name FROM users WHERE name IN (1, 2, 3)', "|", 'SELECT name FROM users WHERE name IN (?a)', [[1,2,3]]],
            # либо в пары идентификатор и значение через запятую (ассоциативный массив).
            ["SELECT name FROM users WHERE name `position` = 'comrade'", "|", 'SELECT name FROM users WHERE name ?a', [["position" => 'comrade']]],
            # Каждое значение из массива форматируется в зависимости от его типа (идентично универсальному параметру без спецификатора).
            ["SELECT name FROM users WHERE name IN (1, '2', NULL)", "|", 'SELECT name FROM users WHERE name IN (?a)', [[1,'2',null]]],
            # Также необходимо реализовать условные блоки, помечаемые фигурными скобками.
            # Если внутри условного блока есть хотя бы один параметр со специальным значением, то блок не попадает в сформированный запрос.
            ['SELECT |  from not skip 1', "|", 'SELECT | { skip ?} from {not skip ?d}', ["|", 1]],
        ];
    }
}