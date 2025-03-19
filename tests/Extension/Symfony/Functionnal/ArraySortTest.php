<?php

declare(strict_types=1);

namespace Extension\Symfony\Functionnal;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ArraySortTest extends WebTestCase
{
    #[DataProvider('providesSortParamsAndTitle')]
    public function testItDisplaySortedTable(string $queryString, array $titles, array $links, string $clickedLink, string $expectedUrl): void
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/array-sort'.$queryString);
        $this->assertResponseIsSuccessful();

        foreach ($titles as $i => $title) {
            $this->assertStringContainsString(
                $title,
                $crawler->filter('tbody > tr:nth-child('.($i + 1).')')->text(),
            );
        }

        foreach ($links as $column => $order) {
            $this->assertStringContainsString(
                '?'.$column.'='.$order,
                $crawler->filter('thead th[data-col='.$column.'] a')->attr('href'),
            );
        }

        $client->clickLink($clickedLink);
        $this->assertResponseIsSuccessful();
        $this->assertSame($expectedUrl, $client->getRequest()->getRequestUri());
    }

    public static function providesSortParamsAndTitle(): iterable
    {
        yield 'Default order' => [
            '',
            [
                'The third title',
                'The fourth title',
                'The second title',
                'The fifth title',
                'The first title',
            ],
            ['c' => 'DESC', 'a' => 'ASC'],
            'C',
            '/array-sort?c=DESC',
        ];

        yield 'Title Ascending (First Column)' => [
            '?title=ASC',
            [
                'The fifth title',
                'The first title',
                'The fourth title',
                'The second title',
                'The third title',
            ],
            ['title' => 'DESC', 'a' => 'ASC'],
            'Title',
            '/array-sort?title=DESC',
        ];

        yield 'Title Descending (First Column)' => [
            '?title=DESC',
            [
                'The third title',
                'The second title',
                'The fourth title',
                'The first title',
                'The fifth title',
            ],
            ['title' => 'ASC'],
            'Title',
            '/array-sort?title=ASC',
        ];

        yield 'Integer column Ascending' => [
            '?a=ASC',
            [
                'The first title',
                'The second title',
                'The third title',
                'The fourth title',
                'The fifth title',
            ],
            ['a' => 'DESC'],
            'C',
            '/array-sort?c=ASC',
        ];
    }
}
