<h1>Alle Termine (Erweiterter Ablaufplan)</h1>
<div>
    <?= $sortierung ?>
<br />
</div>
<table border="1" style="width: 100%">
    <colgroup>
        <col width="1*">
        <col width="1*">
        <col width="1*">
        <col width="1*">
        <col width="1*">
        <col width="1*">
    </colgroup>
    <tr>
        <th>Datum</th>
        <th>Start</th>
        <th>Ende</th>
        <th>Dozent</th>
        <th>Gruppe</th>
        <th>Thema</th>
    </tr>
    <? FOREACH($termine as $t): ?>
    <tr>
        <td><?= date("D - d.m.Y", $t["date"]) ?></td>
        <td><?= date("H:i", $t["date"]) ?></td>
        <td><?= date("H:i", $t["end_time"]) ?></td>
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
        <td><?  $grp =  termin_related_groups::findBytermin_id($t["termin_id"]);
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
            <? $themenid = themen_termine::findBytermin_id($t["termin_id"]) ?>
            <? $thema = themen::find($themenid[0]->issue_id) ?>
            <?= $thema->title ?>
        </td>
    </tr>
    <? ENDFOREACH ?>
</table>