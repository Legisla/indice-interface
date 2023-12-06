<?php

namespace App\Models;

use App\Enums\Initiator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Enums\ImportationStatus;

/**
 * @property int    $id
 * @property int    $legislature_id
 * @property string $status
 * @property string $initiator
 * @property string $stages
 * @property Carbon legislature_start
 * @property Carbon legislature_end
 * @property Carbon $started_at
 * @property Carbon $finished_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Importation extends Model
{
    use HasFactory;

    protected $table = 'importations';

    protected $guarded = ['id'];

    protected $fillable = [
        'legislature_id',
        'status',
        'initiator',
        'stages',
        'legislature_start',
        'legislature_end',
        'started_at',
        'finished_at',
    ];

    protected $dates = [
        'legislature_start',
        'legislature_end',
        'started_at',
        'finished_at',
        'created_at',
        'updated_at',
    ];

    public static function createOrGetLast(
        string    $legislature_id,
        Initiator $initiator,
        bool      $cleanStart,
        array     $stages,
        Carbon    $legislature_start,
        Carbon    $legislature_end
    ): self
    {
        if ($cleanStart) {
            self::whereNull('finished_at')->update(['status' => ImportationStatus::CANCELED]);
        } else if (
            $lastImportation = self::orderBy('id', 'desc')->whereIn(
                'status',
                [ImportationStatus::FAILED, ImportationStatus::STARTED]
            )->first()
        ) {
            return $lastImportation;
        }

        return self::create([
            'legislature_id' => $legislature_id,
            'status' => ImportationStatus::STARTED,
            'stages' => json_encode($stages),
            'legislature_start' => $legislature_start,
            'legislature_end' => $legislature_end,
            'started_at' => now(),
            'initiator' => $initiator,
        ]);
    }

    public static function getLastFailed(): ?self
    {
        $failed = self::where('status', ImportationStatus::FAILED)
            ->orderBy('id', 'desc')
            ->first();

        if ($failed) {
            return $failed;
        } else {
            return null;
        }
    }

    public function finish(): void
    {
        $this->update([
            'status' => ImportationStatus::FINISHED,
            'finished_at' => now(),
        ]);
    }

    public function fail(): void
    {
        $this->update([
            'status' => ImportationStatus::FAILED
        ]);
    }

    public function getStages(): array
    {
        return json_decode($this->stages, true);
    }

    public function updateStages(array $stages): void
    {
        $this->update([
            'stages' => json_encode($stages),
        ]);
    }

    public static function getLastCompletedEnd(): ?string
    {
        return self::getLastCompleted()
            ?->finished_at
            ?->format('d/m/Y');
    }

    public static function getLastCompleted(): ?self
    {
        return self::where('status', ImportationStatus::FINISHED)
            ->where('legislature_id', config('source.legislature_id'))
            ->orderBy('finished_at', 'desc')
            ->first();
    }

    public function getStagesFormated(): string
    {
        $stages = $this->getStages();
        $longer = max(array_map(fn($item) => strlen($item['stage']), $stages));

        return array_reduce(
            array: $stages,
            callback: fn($carry, $item) => $carry . sprintf(
                    "%s -%s> %s" . PHP_EOL,
                    $item['stage'],
                    str_repeat('-', ($longer - strlen($item['stage']))),
                    $item['status']
                ),
            initial: PHP_EOL
        );
    }

    public function getStartFormated(): string
    {
        return $this->started_at->format('d/m/Y H:i:s');
    }

    public function getEndFormated(): string
    {
        return $this->finished_at ?
            $this->finished_at->format('d/m/Y H:i:s') :
            'not finished yet';
    }
}
