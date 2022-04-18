<?php

namespace Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices;

use Bakgul\ResourceCreator\Services\RegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices\VueStoreSectionRegistrationRequestService;
use Bakgul\ResourceCreator\Tasks\CombineImports;

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
        CombineImports::_(
            $this->lineSpecs(),
            $this->request['attr']['target_file']
        );
    }
}
