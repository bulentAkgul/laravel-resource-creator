<?php

namespace Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices;

use Bakgul\Kernel\Helpers\Arry;
use Bakgul\ResourceCreator\Helpers\Options;
use Bakgul\ResourceCreator\Services\RegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices\VueStoreSectionRegistrationRequestService;
use Illuminate\Support\Str;

class VueStoreSectionRegistrationService extends RegistrationService
{
    public function handle(array $request)
    {
        if ($request['attr']['pipeline']['options']['store'] == 'pinia') return;

        $requestService = new VueStoreSectionRegistrationRequestService;

        $this->request = $requestService->handle($request);

        foreach ($this->setParts() as $part) {
            $this->request = $requestService->extend($this->request, $part);

            $this->register($this->lineSpecs(), $this->blockSpecs($part), $part);
        }

        $this->combineImports();
    }

    private function setParts(): array
    {
        return array_filter(
            ['state', 'actions', 'mutations', 'getters'],
            fn ($x) => $x != 'mutations' || $this->request['attr']['pipeline']['options']['store'] != 'pinia'
        );
    }
    
    private function lineSpecs()
    {
        return [
            'start' => ['* IMPORTS *', 1],
            'end' => ['* STORE *', -1],
        ];
    }

    private function blockSpecs(string $part)
    {
        return [
            'start' => ["{$part}: {", 0],
            'isSortable' => true
        ];
    }

    private function combineImports()
    {
        [$start, $_, $end, $imports] = $this->getImports();

        $this->purifyContent($start, $end);

        $this->regenerateContent($start, $this->groupImports($imports));

        $this->write();
    }

    private function getImports()
    {
        return $this->getCodeLines($this->setLineSpecs($this->lineSpecs()));
    }

    private function groupImports(array $imports): array
    {
        $combined = [];

        foreach ($this->createGroups($imports) as $file => $group) {
            $combined[] = 'import ' . $this->extendParts($group) . " from {$file}";
        }

        return $combined;
    }

    private function extendParts(array $group)
    {
        $group = array_reduce($group, fn ($p, $c) => $this->addPart($p, $c), []);

        return (count($group) > 1 ? '{ ' : '') . implode(', ', $group) . (count($group) > 1 ? ' }' : '');
    }

    private function addPart(array $carry, string $current)
    {
        return array_merge($carry, [trim(Str::between($current, 'import', 'from'))]);
    }

    private function createGroups(array $imports): array
    {
        $groups = [];

        foreach ($imports as $import) {
            $key = trim(Str::between($import, 'from', ';'));

            if (!Arry::has($key, $groups)) $groups[$key] = [];

            $groups[$key][] = $import;
        }

        return $groups;
    }
}