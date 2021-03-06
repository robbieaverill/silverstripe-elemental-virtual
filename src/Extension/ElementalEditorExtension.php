<?php

namespace SilverStripe\ElementalVirtual\Extensions;

use SilverStripe\ORM\DataExtension;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ElementalVirtual\Forms\ElementalGridFieldAddExistingAutocompleter;
use SilverStripe\ElementalVirtual\Forms\ElementalGridFieldDeleteAction;
use SilverStripe\ElementalVirtual\Model\ElementVirtual;

class ElementalEditorExtension extends DataExtension
{
    public function updateField($gridField)
    {
        $searchList = BaseElement::get()->filter('AvailableGlobally', 1);

        $gridField->getConfig()
            ->removeComponentsByType(GridFieldDeleteAction::class)
            ->addComponent($autocomplete = new ElementalGridFieldAddExistingAutocompleter('toolbar-header-right'))
            ->addComponent(new ElementalGridFieldDeleteAction());

        $autocomplete->setSearchList($searchList);
        $autocomplete->setResultsFormat('($ID) $Title');
        $autocomplete->setSearchFields(array('ID', 'Title'));
    }

    public function updateGetTypes(&$types)
    {
        if (isset($types[ElementVirtual::class])) {
            unset($types[ElementVirtual::class]);
        }
    }
}
