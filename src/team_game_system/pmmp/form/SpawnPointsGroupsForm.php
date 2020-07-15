<?php


namespace team_game_system\pmmp\form;


use form_builder\models\simple_form_elements\SimpleFormButton;
use form_builder\models\SimpleForm;
use pocketmine\Player;
use team_game_system\model\Map;
use team_game_system\service\AddSpawnPointsGroupService;
use team_game_system\store\MapsStore;

class SpawnPointsGroupsForm extends SimpleForm
{
    public function __construct(Map $map) {

        $buttons = [
            new SimpleFormButton(
                "グループを追加",
                null,
                function (Player $player) use ($map) {
                    AddSpawnPointsGroupService::execute($map);
                    //再取得で更新
                    $player->sendForm(new SpawnPointsGroupsForm(MapsStore::findByName($map->getName())));
                }
            )
        ];

        foreach ($map->getSpawnPointGroups() as $key => $group) {
            $buttons[] = new SimpleFormButton(
                $key,
                null,
                function (Player $player) use ($map, $key, $group) {
                    $player->sendForm(new SpawnPointsGroupDetailForm($map, $key, $group));
                }
            );
        }
        parent::__construct($map->getName(), "", $buttons);
    }

    function onClickCloseButton(Player $player): void {
        // TODO: Implement onClickCloseButton() method.
    }
}