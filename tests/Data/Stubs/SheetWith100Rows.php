<?php

namespace Developergf\Excel\Tests\Data\Stubs;

use Illuminate\Support\Collection;
use Developergf\Excel\Concerns\Exportable;
use Developergf\Excel\Concerns\FromCollection;
use Developergf\Excel\Concerns\RegistersEventListeners;
use Developergf\Excel\Concerns\ShouldAutoSize;
use Developergf\Excel\Concerns\WithEvents;
use Developergf\Excel\Concerns\WithTitle;
use Developergf\Excel\Events\BeforeWriting;
use Developergf\Excel\Tests\TestCase;
use Developergf\Excel\Writer;

class SheetWith100Rows implements FromCollection, WithTitle, ShouldAutoSize, WithEvents
{
    use Exportable, RegistersEventListeners;

    /**
     * @var string
     */
    private $title;

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $collection = new Collection;
        for ($i = 0; $i < 100; $i++) {
            $row = new Collection();
            for ($j = 0; $j < 5; $j++) {
                $row[] = $this->title() . '-' . $i . '-' . $j;
            }

            $collection->push($row);
        }

        return $collection;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @param BeforeWriting $event
     */
    public static function beforeWriting(BeforeWriting $event)
    {
        TestCase::assertInstanceOf(Writer::class, $event->writer);
    }
}
