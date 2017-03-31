<?php require "_header.view.php";?>
    <div class="panel-body">
        <div class="well">
            <table id="videogame_grid" class="table table-condensed bootgrid-table" width="60%" cellspacing="0">
                <thead>
                    <tr>
                        <th><a href="#" data-toggle="tooltip" title="Create row" id="create"><span class="table-add glyphicon glyphicon-plus"></span></a></th>
                        <th>Name</th>
                        <th>Release date <small>(e.g. January 24, 2017)</small></th>
                    </tr>
                </thead>
                <tbody id="_editable_table">
                    <?php
                        date_default_timezone_set('Europe/Helsinki');
                        $currentDate = date('Y-m-d');
                        $currentMonth = date('m');
                        $currentYear = date('Y');
                    ?>
                    <?php foreach($games as $game) :?>
                        <?php if(!is_null($game->name) && !is_null($game->releasedate) && date("Y-m-d", strtotime(htmlspecialchars($game->releasedate))) <= $currentDate):?>
                            <tr class="active" data-row-id="<?= htmlspecialchars($game->id);?>">
                        <?php elseif(!is_null($game->name) && !is_null($game->releasedate) && date("m", strtotime(htmlspecialchars($game->releasedate))) == $currentMonth && date("Y", strtotime(htmlspecialchars($game->releasedate))) == $currentYear):?>
                            <tr class="success" data-row-id="<?= htmlspecialchars($game->id);?>">
                        <?php else:?>
                            <tr class="info" data-row-id="<?= htmlspecialchars($game->id);?>">
                        <?php endif;?>
                            <td><a href="#" data-toggle="tooltip" title="Remove row" class="remove"><span class="glyphicon glyphicon-remove"></span></a>&nbsp;&nbsp;<a href="#" data-toggle="tooltip" title="Update row" class="edit"><span class="glyphicon glyphicon-edit"></span></a></td>
                            <td class="editable-col" contenteditable="false" col-index='0' oldVal="<?= htmlspecialchars($game->name);?>"><?= htmlspecialchars($game->name);?></td>
                            <td class="editable-col" contenteditable="false" col-index='1' oldVal="<?php if(!is_null($game->releasedate)):?><?= date_format(date_create(htmlspecialchars($game->releasedate)), "F d, Y");?><?php endif;?>"><?php if(!is_null($game->releasedate)):?><?= date_format(date_create(htmlspecialchars($game->releasedate)), "F d, Y");?><?php endif;?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div><!--panel-body-->
<?php require "_footer.view.php";?>