<?php


namespace team_game_system\pmmp\form;


use form_builder\models\modal_form_elements\ModalFormButton;
use form_builder\models\ModalForm;
use pocketmine\Player;
use team_game_system\model\Map;
use team_game_system\store\MapsStore;

class MapRemoveSpawnPointsGroupForm extends ModalForm
{
    private $map;
    private $groupIndex;

    public function __construct(Map $map,int $groupIndex) {
        $this->map = $map;
        $this->groupIndex = $groupIndex;
        parent::__construct($map->getName(),
            "index:({$groupIndex})を削除しますか？",
            new ModalFormButton("はい"),
            new ModalFormButton("いいえ"));
    }

    function onClickCloseButton(Player $player): void {
        $player->sendForm(new SpawnPointsGroupsForm($this->map));
    }

    public function onClickButton1(Player $player): void {
        //更新後のデータを送る
        $player->sendForm(new SpawnPointsGroupsForm(MapsStore::findByName($this->map->getName())));
        $player->sendMessage("index:({$this->groupIndex})を削除しました");
    }

    public function onClickButton2(Player $player): void {
        $player->sendForm(new SpawnPointsGroupsForm($this->map));
    }
}