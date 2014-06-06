<h1>Termine der Dozenten (Erweiterter Ablaufplan)</h1>
<div>
<?= $sortierung ?>
</div>
<? FOREACH ($dozenten as $d) : ?>
<h1>  <?= $d->vorname ?> <?= $d->nachname ?> (<?= $d->perms ?>)</h1>
<table border="1" style="width: 100%">
    <colgroup>
        <col width="1*">
        <col width="1*">
        <col width="1*">
        <col width="1*">
        <col width="2*">
    </colgroup>
    <tr>
        <th>Datum</th>
        <th>Start</th>
        <th>Ende</th>
        <th>Gruppe</th>
        <th>Thema</th>
    </tr>
    <?
        $Dozententermine = termin_related_persons::findByUser_id($d->user_id);
        foreach($Dozententermine as $t):
            $termine = termine::find($t["range_id"]);
            if($termine["range_id"] == $semid) :
    ?>
        <tr>
            <td><?= date("D - d.m.Y", $termine["date"]) ?></td>
            <td><?= date("H:i", $termine["date"]) ?></td>
            <td><?= date("H:i", $termine["end_time"]) ?></td>
            <td><?  $grp =  termin_related_groups::findBytermin_id($termine["termin_id"]);
                if(!empty($grp[0])) :
                    foreach($grp as $g) :  ?>
                        <? $s = statusgruppen::find($g["statusgruppe_id"])  ?>
                        <?= $s->name ?>
                    <? ENDFOREACH ?>
                <? ELSE : ?>
                    <? $grp  = statusgruppen::findByRange_id($semid)  ?>
                    <? foreach($grp as $g) :  ?>
                        <?= $g->name ?>
                    <? ENDFOREACH ?>
                <? ENDIF ?>
            </td>
            <td>
                <? $themenid = themen_termine::findBytermin_id($termine["termin_id"]) ?>
                <? $thema = themen::find($themenid[0]->issue_id) ?>
                <?= $thema->title ?>

            </td>
        </tr>
    <? ENDIF ?>
    <? ENDFOREACH ?>
</table>
<br />
<? ENDFOREACH ?>
<h1>Termine für alle Dozenten</h1>
<table border="1" style="width: 100%">
    <colgroup>
        <col width="1*">
        <col width="1*">
        <col width="1*">
        <col width="1*">
        <col width="2*">
    </colgroup>
    <tr>
        <th>Datum</th>
        <th>Start</th>
        <th>Ende</th>
        <th>Gruppe</th>
        <th>Thema</th>
    </tr>
    <?
    $Dozententermine = termine::OhneDozenten($semid);
    foreach($Dozententermine as $termine):
        if($termine["range_id"] == $semid) :
        ?>
        <tr>
            <td><?= date("D - d.m.Y", $termine["date"]) ?></td>
            <td><?= date("H:i", $termine["date"]) ?></td>
            <td><?= date("H:i", $termine["end_time"]) ?></td>
            <td><?  $grp =  termin_related_groups::findBytermin_id($termine["termin_id"]);
                if(!empty($grp[0])) :
                    foreach($grp as $g) :  ?>
                        <? $s = statusgruppen::find($g["statusgruppe_id"])  ?>
                        <?= $s->name ?>
                    <? ENDFOREACH ?>
                <? ELSE : ?>
                    <? $grp  = statusgruppen::findByRange_id($semid)  ?>
                    <? foreach($grp as $g) :  ?>
                        <?= $g->name ?>
                    <? ENDFOREACH ?>
                <? ENDIF ?>
            </td>
            <td>
                <? $themenid = themen_termine::findBytermin_id($termine["termin_id"]) ?>
                <? $thema = themen::find($themenid[0]->issue_id) ?>
                <?= $thema->title ?>

            </td>
        </tr>
        <? ENDIF ?>
    <? ENDFOREACH ?>
</table>