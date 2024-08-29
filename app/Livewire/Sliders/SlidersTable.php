<?php

namespace App\Livewire\Sliders;

use App\Models\Slider;
use Carbon\Carbon;
use App\Exports\SlidersExport;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class SlidersTable extends DataTableComponent
{
    protected $model = Slider::class;
    public array $bulkActions = [
        'exportToExcel' => 'Export',
        'deleteSelected' => 'Delete',
        'setSelectedActive' => 'Set Active',
    ];

    public function configure(): void
    {
        $this
            ->setPrimaryKey('id')
            ->setDefaultSort('id', 'asc')
            ->setComponentWrapperAttributes([
                'default' => true,
                'class' => 'px-4 py-8',
            ])
            ->setTheadAttributes([
                'default' => true,
                'class' => 'bg-gray-100',
            ]);

        $this->setSearchDebounce(400);
        $this->setSearchPlaceholder('Search for slider...');

        $this->setConfigurableAreas([
            'toolbar-left-end' => [
                'components.link.index', [
                    'withIcon' => true,
                    'icon' => 'ph ph-plus',
                    'text' => 'Add Slider',
                    'href' => route('admin.sliders.create'),
                ]
            ],
        ]);

    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->excludeFromColumnSelect()
                ->sortable(),
            Column::make("Title", "title")
                ->excludeFromColumnSelect()
                ->searchable(),
            Column::make("Subtitle", "subtitle")
                ->excludeFromColumnSelect()
                ->searchable(),
            Column::make("Starting Price (IDR)", "starting_price")
                ->excludeFromColumnSelect()
                ->sortable(),
            Column::make("Position", "position")
                ->excludeFromColumnSelect()
                ->sortable(),
            BooleanColumn::make("Active", "is_active")
                ->sortable(),
            Column::make("Url", "url")
                ->collapseAlways(),
            Column::make("Banner", "banner")
                ->collapseAlways(),
            Column::make("Created at", "created_at")
                ->format(fn($value, $row, Column $column) => Carbon::parse($value)->format('d M Y'))
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->format(fn($value, $row, Column $column) => Carbon::parse($value)->format('d M Y'))
                ->sortable(),
            Column::make('Action')
                ->label(
                    fn($row, Column $column) => view('components.datatables.action-column')->with(
                        [
                            // 'viewLink' => "/admin/sliders/1",
                            'editLink' => route('admin.sliders.edit', $row),
                            'deleteLink' => "/admin/sliders/1",
                        ]
                    )
                )->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Active', 'is_active')
                ->options([
                    '' => 'All',
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('is_active', true);
                    } elseif ($value === '0') {
                        $builder->where('is_active', false);
                    }
                }),
        ];
    }

    public function exportToExcel()
    {
        $selectedIds = $this->getSelected();
        return Excel::download(new SlidersExport($selectedIds), 'sliders.xlsx');
    }

    public function deleteSelected()
    {
        if (!$this->getSelected()) {
            return;
        }

        DB::transaction(function () {
            Slider::whereIn('id', $this->getSelected())->delete();
        });

        session()->flash('toast-notification', [
            'message' => 'Selected sliders have been deleted successfully.',
            'type' => 'success',
        ]);
        $this->clearSelected();
    }

    public function setSelectedActive()
    {
        if (!$this->getSelected())
        {
            return;
        }

        DB::transaction(function() {
            Slider::whereIn('id', $this->getSelected())->update(['is_active' => true]);
        });

        session()->flash('toast-notification', [
            'message' => 'Selected sliders have been activate successfully.',
            'type' => 'success',
        ]);

        $this->clearSelected();
        return $this->redirectRoute('admin.sliders.index');
    }
}
