<?php

namespace App\Enums;

enum Stages: string
{
    case PARTIES = 'parties';
    case CONGRESSPEOPLE = 'congresspeople';
    case EXPENSES = 'expenses';
    case EVENTS = 'events';
    case VOTATIONS = 'votations';
    case POSITIONS = 'positions';
    case PROPOSITIONS = 'propositions';
    case FRONTS = 'fronts';
    case BODIES = 'bodies';
    case AMENDMENTS = 'amendments';
    case INDICATORS = 'indicators';
    case SCORES = 'scores';


    public function processClass(): string
    {
        return Stages::getProcessClass($this);
    }

    public static function getProcessClass(self $value): string
    {
        return match ($value) {
            self::PARTIES => '\App\Services\Resources\PartiesService',
            self::CONGRESSPEOPLE => '\App\Services\Resources\CongressPeopleService',
            self::EXPENSES => '\App\Services\Resources\ExpensesService',
            self::EVENTS => '\App\Services\Resources\EventsService',
            self::VOTATIONS => '\App\Services\Resources\VotationsService',
            self::POSITIONS => '\App\Services\Resources\PositionsService',
            self::PROPOSITIONS => '\App\Services\Resources\PropositionsService',
            self::FRONTS => '\App\Services\Resources\FrontsService',
            self::BODIES => '\App\Services\Resources\BodiesService',
            self::AMENDMENTS => '\App\Services\Resources\AmendmentsService',
            self::INDICATORS => '\App\Services\Resources\IndicatorsService',
            self::SCORES => '\App\Services\ScoreService',
        };
    }

    public function yeldVerb(): string
    {
        return Stages::getVerb($this);
    }

    public static function getVerb(self $value): string
    {
        return match ($value) {
            self::PARTIES,
            self::CONGRESSPEOPLE,
            self::EXPENSES,
            self::EVENTS,
            self::VOTATIONS,
            self::POSITIONS,
            self::PROPOSITIONS,
            self::FRONTS,
            self::AMENDMENTS,
            self::BODIES => 'importing ',
            self::INDICATORS,
            self::SCORES => 'processing ',
        };
    }
}
