<?php


namespace team_game_system\pmmp\form;


use form_builder\models\custom_form_elements\Input;
use form_builder\models\CustomForm;
use pocketmine\Player;
use team_game_system\model\Map;
use team_game_system\service\CreateMapService;

class MapCreateForm extends CustomForm
{
    private $mapNameInput;

    public function __construct() {
        $this->mapNameInput = new Input("マップ名", "", "");
        parent::__construct("マップ作成", [
            $this->mapNameInput
        ]);
    }

    function onSubmit(Player $player): void {
        $mapName = $this->mapNameInput->getResult();
        CreateMapService::execute(new Map($mapName, $player->getLevel()->getName(), []));
        $player->sendForm(new MapMenuForm());
    }

    function onClickCloseButton(Player $player): void {
        $player->sendForm(new MapMenuForm());
    }
}