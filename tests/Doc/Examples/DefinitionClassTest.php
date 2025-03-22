<?php

namespace UnZeroUn\Sorter\Tests\Doc\Examples;

use PHPUnit\Framework\TestCase;

final class DefinitionClassTest extends TestCase
{
    public function testItOutputsExpectedResult(): void
    {
        ob_start();
        require __DIR__.'/../../../examples/definition-class.php';
        $result = ob_get_clean();

        $this->assertSame($result, file_get_contents(__FILE__, offset: __COMPILER_HALT_OFFSET__));
    }
}

__halt_compiler();

 Default sort (Ascending date):
 --------------------------------------------------------------------------------------------------------
 | Title                                                               | Date       | Weight | Comments |
 --------------------------------------------------------------------------------------------------------
 | Colo contego possimus tabgo cunabula agnitio capio delectatio vivo. | 2025-01-01 | 10     | 3        |
 | Ventito suffragium caries vel paens omnis.                          | 2025-02-01 | 10     | 5        |
 | Angustus nobis auditor pecco.                                       | 2025-03-01 | 0      | 7        |
 | Asper arx baiulus adnuo velit depereo fuga tempore decor.           | 2025-04-01 | 100    | 9        |
 | Triduana thesis trepide adipiscor maiores subiungo sono rerum sui.  | 2025-05-01 | 40     | 11       |
 | Abstergo teneo vox nihil taedium admoneo deinde.                    | 2025-06-01 | 40     | 13       |
 | Ventito suffragium caries vel paens omnis.                          | 2025-07-01 | 40     | 12       |
 | Modi nihil accedo ut id sollers.                                    | 2025-08-01 | 70     | 10       |
 | Ter absconditus valetudo depono ad decipio summopere.               | 2025-09-01 | 30     | 8        |
 | Cognatus decimus dicta consectetur tergum antepono.                 | 2025-10-01 | 20     | 6        |
 | Avarus claudeo utrum sollicito tergo.                               | 2025-11-01 | 100    | 4        |
 | Id adfectus correptius veritatis valde placeat.                     | 2025-12-01 | 10     | 2        |
 --------------------------------------------------------------------------------------------------------
