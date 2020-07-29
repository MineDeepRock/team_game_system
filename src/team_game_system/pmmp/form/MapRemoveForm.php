<?php


namespace team_game_system\pmmp\form;


use form_builder\models\modal_form_elements\ModalFormButton;
use form_builder\models\ModalForm;
use pocketmine\Player;
use team_game_system\model\Map;
use team_game_system\service\RemoveMapService;

class MapRemoveForm extends ModalForm
{
    private $map;

    public function __construct(Map $map) {
        $this->map = $map;
        parent::__construct($map->getName(),
            "削除しますか？",
            new ModalFormButton("はい"),
            new ModalFormButton("いいえ"));
    }

    function onClickCloseButton(Player $player): void {
        $player->sendForm(new MapDetailForm($this->map));
    }

    public function onClickButton1(Player $player): void {
        RemoveMapService::execute($this->map);
        $player->sendForm(new MapListForm());
        $player->sendMessage("Map:({$this->map->getName()})を削除しました");
    }

    public function onClickButton2(Player $player): void {
        $player->sendForm(new MapDetailForm($this->map));
    }
}