<?php

namespace UnZeroUn\Sorter\Tests\Doc\Examples;

use PHPUnit\Framework\TestCase;

final class BasicDoctrineOrmSortTest extends TestCase
{
    public function testItOutputsExpectedResult(): void
    {
        ob_start();
        require __DIR__.'/../../../examples/basic-doctrine-orm-sort.php';
        $result = ob_get_clean();

        $this->assertSame($result, file_get_contents(__FILE__, offset: __COMPILER_HALT_OFFSET__));
    }
}

__halt_compiler();

 Default sort (Ascending date):
 SELECT p, COUNT(p.comments) AS HIDDEN comments_count FROM Post p INNER JOIN p.comments comments GROUP BY p.id ORDER BY p.date ASC


 Single column sort (Ascending title):
 SELECT p, COUNT(p.comments) AS HIDDEN comments_count FROM Post p INNER JOIN p.comments comments GROUP BY p.id ORDER BY p.title ASC


 Double column sort (Ascending Weight, Ascending title):
 SELECT p, COUNT(p.comments) AS HIDDEN comments_count FROM Post p INNER JOIN p.comments comments GROUP BY p.id ORDER BY p.weight ASC, p.title ASC
