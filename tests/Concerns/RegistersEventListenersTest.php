<?php

namespace Developergf\Excel\Tests\Concerns;

use Developergf\Excel\Events\AfterSheet;
use Developergf\Excel\Events\BeforeExport;
use Developergf\Excel\Events\BeforeImport;
use Developergf\Excel\Events\BeforeSheet;
use Developergf\Excel\Events\BeforeWriting;
use Developergf\Excel\Reader;
use Developergf\Excel\Sheet;
use Developergf\Excel\Tests\Data\Stubs\BeforeExportListener;
use Developergf\Excel\Tests\Data\Stubs\ExportWithEvents;
use Developergf\Excel\Tests\Data\Stubs\ExportWithRegistersEventListeners;
use Developergf\Excel\Tests\Data\Stubs\ImportWithRegistersEventListeners;
use Developergf\Excel\Tests\TestCase;
use Developergf\Excel\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RegistersEventListenersTest extends TestCase
{
    /**
     * @test
     */
    public function events_get_called_when_exporting()
    {
        $event = new ExportWithRegistersEventListeners();

        $eventsTriggered = 0;

        $event::$beforeExport = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(BeforeExport::class, $event);
            $this->assertInstanceOf(Writer::class, $event->writer);
            $eventsTriggered++;
        };

        $event::$beforeWriting = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(BeforeWriting::class, $event);
            $this->assertInstanceOf(Writer::class, $event->writer);
            $eventsTriggered++;
        };

        $event::$beforeSheet = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(BeforeSheet::class, $event);
            $this->assertInstanceOf(Sheet::class, $event->sheet);
            $eventsTriggered++;
        };

        $event::$afterSheet = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(AfterSheet::class, $event);
            $this->assertInstanceOf(Sheet::class, $event->sheet);
            $eventsTriggered++;
        };

        $this->assertInstanceOf(BinaryFileResponse::class, $event->download('filename.xlsx'));
        $this->assertEquals(4, $eventsTriggered);
    }

    /**
     * @test
     */
    public function events_get_called_when_importing()
    {
        $event = new ImportWithRegistersEventListeners();

        $eventsTriggered = 0;

        $event::$beforeImport = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(BeforeImport::class, $event);
            $this->assertInstanceOf(Reader::class, $event->reader);
            $eventsTriggered++;
        };

        $event::$beforeSheet = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(BeforeSheet::class, $event);
            $this->assertInstanceOf(Sheet::class, $event->sheet);
            $eventsTriggered++;
        };

        $event::$afterSheet = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(AfterSheet::class, $event);
            $this->assertInstanceOf(Sheet::class, $event->sheet);
            $eventsTriggered++;
        };

        $event->import('import.xlsx');
        $this->assertEquals(3, $eventsTriggered);
    }

    /**
     * @test
     */
    public function can_have_invokable_class_as_listener()
    {
        $event = new ExportWithEvents();

        $event->beforeExport = new BeforeExportListener(function ($event) {
            $this->assertInstanceOf(BeforeExport::class, $event);
            $this->assertInstanceOf(Writer::class, $event->writer);
        });

        $this->assertInstanceOf(BinaryFileResponse::class, $event->download('filename.xlsx'));
    }
}
