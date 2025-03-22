<?php

namespace UnZeroUn\Sorter\Tests\Doc\Examples;

use PHPUnit\Framework\TestCase;

final class BasicArraySortTest extends TestCase
{
    public function testItOutputsExpectedResult(): void
    {
        ob_start();
        require __DIR__.'/../../../examples/basic-array-sort.php';
        $result = ob_get_clean();

        $this->assertSame($result, file_get_contents(__FILE__, offset: __COMPILER_HALT_OFFSET__));
    }
}

__halt_compiler();

 Original data:
 --------------------------------------------------------------------------------------------------------
 | Title                                                               | Date       | Weight | Comments |
 --------------------------------------------------------------------------------------------------------
 | Id adfectus correptius veritatis valde placeat.                     | 2025-12-01 | 10     | 2        |
 | Avarus claudeo utrum sollicito tergo.                               | 2025-11-01 | 100    | 4        |
 | Cognatus decimus dicta consectetur tergum antepono.                 | 2025-10-01 | 20     | 6        |
 | Ter absconditus valetudo depono ad decipio summopere.               | 2025-09-01 | 30     | 8        |
 | Modi nihil accedo ut id sollers.                                    | 2025-08-01 | 70     | 10       |
 | Ventito suffragium caries vel paens omnis.                          | 2025-07-01 | 40     | 12       |
 | Abstergo teneo vox nihil taedium admoneo deinde.                    | 2025-06-01 | 40     | 13       |
 | Triduana thesis trepide adipiscor maiores subiungo sono rerum sui.  | 2025-05-01 | 40     | 11       |
 | Asper arx baiulus adnuo velit depereo fuga tempore decor.           | 2025-04-01 | 100    | 9        |
 | Angustus nobis auditor pecco.                                       | 2025-03-01 | 0      | 7        |
 | Ventito suffragium caries vel paens omnis.                          | 2025-02-01 | 10     | 5        |
 | Colo contego possimus tabgo cunabula agnitio capio delectatio vivo. | 2025-01-01 | 10     | 3        |
 --------------------------------------------------------------------------------------------------------


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


 String sort (Ascending Title):
 --------------------------------------------------------------------------------------------------------
 | Title                                                               | Date       | Weight | Comments |
 --------------------------------------------------------------------------------------------------------
 | Abstergo teneo vox nihil taedium admoneo deinde.                    | 2025-06-01 | 40     | 13       |
 | Angustus nobis auditor pecco.                                       | 2025-03-01 | 0      | 7        |
 | Asper arx baiulus adnuo velit depereo fuga tempore decor.           | 2025-04-01 | 100    | 9        |
 | Avarus claudeo utrum sollicito tergo.                               | 2025-11-01 | 100    | 4        |
 | Cognatus decimus dicta consectetur tergum antepono.                 | 2025-10-01 | 20     | 6        |
 | Colo contego possimus tabgo cunabula agnitio capio delectatio vivo. | 2025-01-01 | 10     | 3        |
 | Id adfectus correptius veritatis valde placeat.                     | 2025-12-01 | 10     | 2        |
 | Modi nihil accedo ut id sollers.                                    | 2025-08-01 | 70     | 10       |
 | Ter absconditus valetudo depono ad decipio summopere.               | 2025-09-01 | 30     | 8        |
 | Triduana thesis trepide adipiscor maiores subiungo sono rerum sui.  | 2025-05-01 | 40     | 11       |
 | Ventito suffragium caries vel paens omnis.                          | 2025-02-01 | 10     | 5        |
 | Ventito suffragium caries vel paens omnis.                          | 2025-07-01 | 40     | 12       |
 --------------------------------------------------------------------------------------------------------


 Multiple sort (Ascending Weight and Ascending Title):
 --------------------------------------------------------------------------------------------------------
 | Title                                                               | Date       | Weight | Comments |
 --------------------------------------------------------------------------------------------------------
 | Angustus nobis auditor pecco.                                       | 2025-03-01 | 0      | 7        |
 | Colo contego possimus tabgo cunabula agnitio capio delectatio vivo. | 2025-01-01 | 10     | 3        |
 | Id adfectus correptius veritatis valde placeat.                     | 2025-12-01 | 10     | 2        |
 | Ventito suffragium caries vel paens omnis.                          | 2025-02-01 | 10     | 5        |
 | Cognatus decimus dicta consectetur tergum antepono.                 | 2025-10-01 | 20     | 6        |
 | Ter absconditus valetudo depono ad decipio summopere.               | 2025-09-01 | 30     | 8        |
 | Abstergo teneo vox nihil taedium admoneo deinde.                    | 2025-06-01 | 40     | 13       |
 | Triduana thesis trepide adipiscor maiores subiungo sono rerum sui.  | 2025-05-01 | 40     | 11       |
 | Ventito suffragium caries vel paens omnis.                          | 2025-07-01 | 40     | 12       |
 | Modi nihil accedo ut id sollers.                                    | 2025-08-01 | 70     | 10       |
 | Asper arx baiulus adnuo velit depereo fuga tempore decor.           | 2025-04-01 | 100    | 9        |
 | Avarus claudeo utrum sollicito tergo.                               | 2025-11-01 | 100    | 4        |
 --------------------------------------------------------------------------------------------------------


 Indirect sort (Descending comments count):
 --------------------------------------------------------------------------------------------------------
 | Title                                                               | Date       | Weight | Comments |
 --------------------------------------------------------------------------------------------------------
 | Abstergo teneo vox nihil taedium admoneo deinde.                    | 2025-06-01 | 40     | 13       |
 | Ventito suffragium caries vel paens omnis.                          | 2025-07-01 | 40     | 12       |
 | Triduana thesis trepide adipiscor maiores subiungo sono rerum sui.  | 2025-05-01 | 40     | 11       |
 | Modi nihil accedo ut id sollers.                                    | 2025-08-01 | 70     | 10       |
 | Asper arx baiulus adnuo velit depereo fuga tempore decor.           | 2025-04-01 | 100    | 9        |
 | Ter absconditus valetudo depono ad decipio summopere.               | 2025-09-01 | 30     | 8        |
 | Angustus nobis auditor pecco.                                       | 2025-03-01 | 0      | 7        |
 | Cognatus decimus dicta consectetur tergum antepono.                 | 2025-10-01 | 20     | 6        |
 | Ventito suffragium caries vel paens omnis.                          | 2025-02-01 | 10     | 5        |
 | Avarus claudeo utrum sollicito tergo.                               | 2025-11-01 | 100    | 4        |
 | Colo contego possimus tabgo cunabula agnitio capio delectatio vivo. | 2025-01-01 | 10     | 3        |
 | Id adfectus correptius veritatis valde placeat.                     | 2025-12-01 | 10     | 2        |
 --------------------------------------------------------------------------------------------------------
