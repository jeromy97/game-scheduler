<table width="717" cellpadding="3" cellspacing="0" class="speelschema-tabel">
    <col width="103" />
    <col width="69" />
    <col width="14" />
    <col width="62" />
    <col width="62" />
    <col width="9" />
    <col width="66" />
    <col width="141" />
    <tr>
        <td width="115"><strong>Datum</strong></td>
        <?php foreach ($timeSchemes as $timeScheme): ?>
            <td colspan="3" align="center"><strong><?= esc($timeScheme['name']) ?></strong></td>
        <?php endforeach ?>
        <td width="252"><strong>Opmerking</strong></td>
    </tr>
    <?php foreach ($timeSchemeRows as $row): ?>
        <tr>
            <td><?= substr(strftime('%a', strtotime($row['date'])), 0, 2) . ' ' . date('j-n-y', strtotime($row['date'])) ?></td>
            <?php foreach ($timeSchemes as $timeScheme): ?>
                <td width="64" align="right"><?= $timeSchemeColumns[$row['id']][$timeScheme['id']]['timeFrom'] ?></td>
                <td width="7">-</td>
                <td width="73"><?= $timeSchemeColumns[$row['id']][$timeScheme['id']]['timeTo'] ?></td>
            <?php endforeach ?>
            <td><?= esc($row['note']) ?></td>
        </tr>
    <?php endforeach ?>
</table>
