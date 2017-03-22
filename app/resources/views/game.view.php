<?php require "_header.view.php";?>
    <div class="panel-body">
        <?php if(isset($message) && strlen($message) > 0): ?>
        <div class="alert alert-info">
        <?= $message; ?>
        </div>
        <?php endif; ?>
        <div>
            <a href="<?= url('/logout') ?>">Kirjaudu ulos</a>
        </div>
        <table id="videogame_grid" class="table table-condensed bootgrid-table" width="60%" cellspacing="0">
            <thead>
                <tr>
                    <th><a href="#" id="create"><span class="table-add glyphicon glyphicon-plus"></span></a></th>
                    <th>Name</th>
                    <th>Release date</th>
                </tr>
            </thead>
            <tbody id="_editable_table">
                <?php foreach($games as $game) :?>
                    <?php if(!is_null($game->name) && !is_null($game->releasedate) && date("Y-m-d", strtotime(htmlspecialchars($game->releasedate))) <= $currentDate):?>
                        <tr class="active" data-row-id="<?= htmlspecialchars($game->id);?>">
                    <?php elseif(!is_null($game->name) && !is_null($game->releasedate) && date("m", strtotime(htmlspecialchars($game->releasedate))) == $currentMonth):?>
                        <tr class="success" data-row-id="<?= htmlspecialchars($game->id);?>">
                    <?php else:?>
                        <tr class="info" data-row-id="<?= htmlspecialchars($game->id);?>">
                    <?php endif;?>
                        <td><a href="#" class="remove"><span class="glyphicon glyphicon-remove"></span></a>&nbsp;&nbsp;<a href="#" class="edit"><span class="glyphicon glyphicon-edit"></span></a></td>
                        <td class="editable-col" contenteditable="false" col-index='0' oldVal="<?= htmlspecialchars($game->name);?>"><?= htmlspecialchars($game->name);?></td>
                        <td class="editable-col" contenteditable="false" col-index='1' oldVal="<?php if(!is_null($game->releasedate)):?><?= date_format(date_create(htmlspecialchars($game->releasedate)), "F d, Y");?><?php endif;?>"><?php if(!is_null($game->releasedate)):?><?= date_format(date_create(htmlspecialchars($game->releasedate)), "F d, Y");?><?php endif;?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div><!--panel-body-->
<?php require "_footer.view.php";?>