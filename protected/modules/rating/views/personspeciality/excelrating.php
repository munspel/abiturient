<?php
/* @var $data array */
/* @var $Speciality string */
/* @var $Faculty string */
/* @var $_contract_counter integer */
/* @var $_budget_counter integer */
/* @var $_pzk_counter integer */
/* @var $_quota_counter integer */
/* @var $toexcel integer */
?>

<?php
if ($toexcel) {
  header('Content-Type: text/html; charset=windows-1251');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', FALSE);
  header('Pragma: no-cache');
  header('Content-transfer-encoding: binary');
  header('Content-Disposition: attachment; filename=' . iconv("windows-1251", "utf-8",str_replace(array(' ', ':', '.', ',_', '__'), '_', $Speciality) . '.xls'));
  header('Content-Type: application/x-unknown');
}
  ?>
<html>
  <head>
    <meta charset="windows-1251">
    <title><?php echo $Speciality; ?></title>
  </head>
<style id="rating_style">
  TD {
    font-size: 8pt;
    padding: 3px;
    font-family: 'Tahoma';
    vertical-align: middle;
    border:solid 1px black;
  }
  H1 {
    font-size: 16pt;
  }

  .faculty {
    border:solid 0px black;
  }

  .direction {
    border:solid 0px black;
  }

  .license_count {
    border:solid 0px black;
  }

  .budget_count {
    border:solid 0px black;
  }

  .quota_count {
    border:solid 0px black;
  }

  .wave_header {
    font-size: 6pt;
  }
</style>
<?php
?>
<body>
  <TABLE cellspacing="0" border="0"
         style="border-collapse:collapse;" >
    <TR>
      <TD colspan='7' class="faculty">
        <?php echo iconv("utf-8", "windows-1251", 'Факультет:'); ?> 
        <?php echo $Faculty; ?>
      </TD>
    </TR>
    <TR>
      <TD colspan='7' class="direction">
        <?php echo iconv("utf-8", "windows-1251", 'Напрям підготовки: '); ?>
        <?php
        echo $Speciality;
        ?>
      </TD>
    </TR>
    <TR>
      <TD colspan='7' class="license_count">
        <?php echo iconv("utf-8", "windows-1251", 'Ліцензійний обсяг: ');
        echo $_contract_counter + $_budget_counter;
        ?>
      </TD>
    </TR>
    <TR>
      <TD colspan='7' class="budget_count">
        <?php echo iconv("utf-8", "windows-1251", 'Обсяг державного замовлення: ');
        echo $_budget_counter; ?>
      </TD>
    </TR>
    <TR>
      <TD colspan='7' class="quota_count">
        <?php echo iconv("utf-8", "windows-1251", 'з них квота пільговиків: '); ?>
        <?php echo $_pzk_counter; ?>
        <?php echo iconv("utf-8", "windows-1251", ', квота цільовиків: '); ?>
<?php echo $_quota_counter; ?>
      </TD>
    </TR>
    <TR>
      <TD class="number_header">
<?php echo iconv("utf-8", "windows-1251", '№ п/п'); ?>
      </TD>
      <TD class="person_header">
<?php echo iconv("utf-8", "windows-1251", 'ПІБ'); ?>
      </TD>
      <TD class="points_header">
<?php echo iconv("utf-8", "windows-1251", 'Бал'); ?>
      </TD>
      <TD class="pzk_header">
<?php echo iconv("utf-8", "windows-1251", 'Поза конкурс.'); ?>
      </TD>
      <TD class="pv_header">
<?php echo iconv("utf-8", "windows-1251", 'Першочерг.'); ?>
      </TD>
      <TD class="original_header">
<?php echo iconv("utf-8", "windows-1251", 'Оригінал'); ?>
      </TD>
      <TD class="wave_header">
<?php echo iconv("utf-8", "windows-1251", 'Зарах за хвилею'); ?>
      </TD>
    </TR>


<?php if (count($data['quota']) > 0) { ?>
      <TR>
        <TD colspan='7' class="target_committee">
  <?php echo iconv("utf-8", "windows-1251", 'ЦІЛЬОВИЙ ПРИЙОМ'); ?>
        </TD>
      </TR>
<?php } ?>

    <!-- Цільовики-->
<?php for ($i = 1; $i < count($data['quota']) + 1; $i++) { ?>
      <TR data-id="<?php echo $data['quota'][$i]['idPersonSpeciality']; ?>" class="target_row">
        <TD class="num">
  <?php echo ($i); ?>
        </TD>
        <TD class="person">
  <?php echo $data['quota'][$i]['PIB']; ?>
        </TD>
        <TD class="points">
  <?php echo $data['quota'][$i]['Points']; ?>
        </TD>
        <TD class="pzk">
  <?php echo $data['quota'][$i]['isPZK']; ?>
        </TD>
        <TD class="pv">
  <?php echo $data['quota'][$i]['isExtra']; ?>
        </TD>
        <TD class="original">
  <?php echo $data['quota'][$i]['isOriginal']; ?>
        </TD>
        <TD class="wave">

        </TD>
      </TR>
<?php } ?>


<?php if (count($data['pzk']) > 0) { ?>
      <TR>
        <TD colspan='7' class="pzk_committee">
  <?php echo iconv("utf-8", "windows-1251", 'ПОЗА КОНКУРСОМ'); ?>
        </TD>
      </TR>
<?php } ?>

    <!-- ПОЗА КОНКУРСОМ-->
<?php for ($i = 1; $i < count($data['pzk']) + 1; $i++) { ?>
      <TR data-id="<?php echo $data['pzk'][$i]['idPersonSpeciality']; ?>" class="pzk_row">
        <TD class="num">
  <?php echo ($i); ?>
        </TD>
        <TD class="person">
  <?php echo $data['pzk'][$i]['PIB']; ?>
        </TD>
        <TD class="points">
  <?php echo $data['pzk'][$i]['Points']; ?>
        </TD>
        <TD class="pzk">
  <?php echo $data['pzk'][$i]['isPZK']; ?>
        </TD>
        <TD class="pv">
  <?php echo $data['pzk'][$i]['isExtra']; ?>
        </TD>
        <TD class="original">
  <?php echo $data['pzk'][$i]['isOriginal']; ?>
        </TD>
        <TD class="wave">

        </TD>
      </TR>
<?php } ?>


<?php if (count($data['budget']) > 0) { ?>
      <TR>
        <TD colspan='7' class="budget_committee">
  <?php echo iconv("utf-8", "windows-1251", 'ДЕРЖ. ЗАМОВЛЕННЯ'); ?>
        </TD>
      </TR>
<?php } ?>

    <!-- ДЕРЖ. ЗАМОВЛЕННЯ-->
<?php for ($i = 1; $i < count($data['budget']) + 1; $i++) { ?>
      <TR data-id="<?php echo $data['budget'][$i]['idPersonSpeciality']; ?>" class="budget_row">
        <TD class="num">
  <?php echo ($i); ?>
        </TD>
        <TD class="person">
  <?php echo $data['budget'][$i]['PIB']; ?>
        </TD>
        <TD class="points">
  <?php echo $data['budget'][$i]['Points']; ?>
        </TD>
        <TD class="pzk">
  <?php echo $data['budget'][$i]['isPZK']; ?>
        </TD>
        <TD class="pv">
  <?php echo $data['budget'][$i]['isExtra']; ?>
        </TD>
        <TD class="original">
  <?php echo $data['budget'][$i]['isOriginal']; ?>
        </TD>
        <TD class="wave">

        </TD>
      </TR>
    <?php } ?>

<?php if (count($data['contract']) > 0) { ?>
      <TR>
        <TD colspan='7' class="contract_committee">
  <?php echo iconv("utf-8", "windows-1251", 'ЗА КОНТРАКТОМ'); ?>
        </TD>
      </TR>
<?php } ?>

    <!-- ЗА КОНТРАКТОМ-->
<?php for ($i = 1; $i < count($data['contract']) + 1; $i++) { ?>
      <TR data-id="<?php echo $data['contract'][$i]['idPersonSpeciality']; ?>" class="contract_row">
        <TD class="num">
  <?php echo ($i); ?>
        </TD>
        <TD class="person">
  <?php echo $data['contract'][$i]['PIB']; ?>
        </TD>
        <TD class="points">
  <?php echo $data['contract'][$i]['Points']; ?>
        </TD>
        <TD class="pzk">
  <?php echo $data['contract'][$i]['isPZK']; ?>
        </TD>
        <TD class="pv">
  <?php echo $data['contract'][$i]['isExtra']; ?>
        </TD>
        <TD class="original">
  <?php echo $data['contract'][$i]['isOriginal']; ?>
        </TD>
        <TD class="wave">

        </TD>
      </TR>
<?php } ?>

    <!-- НЕ ПРОХОДЯТЬ ЗА КОНКУРСОМ -->
    <?php
    for ($i = 1; $i < count($data['below']) + 1; $i++) {
      if (!isset($data['below'][$i])) {
        continue;
      }
      if ($i == 1) {
        ?>
        <TR>
          <TD colspan='7' class="fatal_line">
        <center>
          =====================================================================
        </center>
      </TD>
    </TR>
    <?php
  }
  ?>
  <TR data-id="<?php echo $data['below'][$i]['idPersonSpeciality']; ?>" class="below_row">
    <TD class="num">
      <?php echo ($i); ?>
    </TD>
    <TD class="person">
      <?php echo $data['below'][$i]['PIB']; ?>
    </TD>
    <TD class="points">
      <?php echo $data['below'][$i]['Points']; ?>
    </TD>
    <TD class="pzk">
      <?php echo $data['below'][$i]['isPZK']; ?>
    </TD>
    <TD class="pv">
      <?php echo $data['below'][$i]['isExtra']; ?>
    </TD>
    <TD class="original">
  <?php echo $data['below'][$i]['isOriginal']; ?>
    </TD>
    <TD class="wave">

    </TD>
  </TR>
<?php } ?>

</TABLE>


<?php ?>

</body>
</html>