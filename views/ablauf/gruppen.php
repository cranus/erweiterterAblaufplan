<h1>Termine der Gruppen (Erweiterter Ablaufplan)</h1>
<div>
<?= $sortierung ?>
</div>
<? FOREACH ($gruppen as $g) : ?>
<h1>  <?= $g->name ?> </h1>
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
        <th>Dozent</th>
        <th>Thema</th>
    </tr>
    <?
        $gruppentermine = termin_related_groups::findbystatusgruppe_id($g["statusgruppe_id"]);
        foreach($gruppentermine as $t):
        $termine = termine::find($t["termin_id"]);
        ?>
        <tr>
            <td><?= date("D - d.m.Y", $termine["date"]) ?></td>
            <td><?= date("H:i", $termine["date"]) ?></td>
            <td><?= date("H:i", $termine["end_time"]) ?></td>
            <td><?
                $doz = termin_related_persons::findByrange_id($t["termin_id"]);
                if(empty($doz[0])) $doz = seminaruser::findBySQL("Seminar_id = ? AND status = ?",array($semid, "dozent"));
                $i = 0;
                foreach($doz as $d) :
                    $user = User::find($d["user_id"] ); ?>
                    <? IF($i > 0): ?>
                    <br />
                <? ENDIF ?>
                    <?= $user->vorname ?> <?= $user->nachname ?> (<?= $user->perms ?>)
                    <? $i++ ?>
                <? ENDFOREACH ?>
            </td>
            <td>
                <? $themenid = themen_termine::findBytermin_id($termine["termin_id"]) ?>
                <? $thema = themen::find($themenid[0]->issue_id) ?>
                <?= $thema->title ?>

            </td>
        </tr>
    <? ENDFOREACH ?>

</table>
<br />
<? ENDFOREACH ?>
<h1>Termine für alle Gruppen</h1>
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
        <th>Dozent</th>
        <th>Thema</th>
    </tr>

<?
$gruppentermine = termine::OhneGruppe($semid);
foreach($gruppentermine as $t):
    $termine = termine::find($t["termin_id"]);
    ?>
    <tr>
        <td><?= date("D - d.m.Y", $termine["date"]) ?></td>
        <td><?= date("H:i", $termine["date"]) ?></td>
        <td><?= date("H:i", $termine["end_time"]) ?></td>
        <td><?
            $doz = termin_related_persons::findByrange_id($t["termin_id"]);
            if(empty($doz[0])) $doz = seminaruser::findBySQL("Seminar_id = ? AND status = ?",array($semid, "dozent"));
            $i = 0;
            foreach($doz as $d) :
                $user = User::find($d["user_id"] ); ?>
                <? IF($i > 0): ?>
                <br />
            <? ENDIF ?>
                <?= $user->vorname ?> <?= $user->nachname ?> (<?= $user->perms ?>)
                <? $i++ ?>
            <? ENDFOREACH ?>
        </td>
        <td>
            <? $themenid = themen_termine::findBytermin_id($termine["termin_id"]) ?>
            <? $thema = themen::find($themenid[0]->issue_id) ?>
            <?= $thema->title ?>

        </td>
    </tr>
<? ENDFOREACH ?>
</table>