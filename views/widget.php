<?php
$options = get_option('paylane_sf_settings');
$kwoty = isset($options['kwoty']) ?  explode(";", $options['kwoty']) : array('1.00', '2.00', '5.00', '10.00', '20.00', '50.00');
$mid = isset($options['mid']) ? $options['mid'] : '';
$salt = isset($options['salt']) ? $options['salt'] : '';
$url = isset($options['url']) ? $options['url'] : null;
$submit = isset($options['url']) ? $options['submit'] : "Wspieram";
$dowolnaKwota = isset($options['dowolnaKwota']) ? ($options['dowolnaKwota'] == 1 ? true : false) : false;
$regulamin = isset($options['regulaminWiadomosc']) ? $options['regulaminWiadomosc'] : null;
$waluty = isset($options['waluty']) ?  explode(";", $options['waluty']) : null;
$cele = isset($options['cele']) ?  explode(";", $options['cele']) : null;

$saPodziekowania = isset($_GET['paylaneSFTY']) ? true : false;

if (!$saPodziekowania) {
    ?>

    <div class="paylane-sf-widget">
        <?php if (isset($cele) && sizeof($cele) > 0 && trim($cele[0]) !== '') { ?>
            <div class="paylane-sf-label">
                Wybierz cel darowizny.
            </div>
            <div class="paylane-sf-purpose-container">
                <select class="paylane-sf-select" required>
                    <?php foreach ($cele as $cel) : ?>
                        <option value="<?= $cel; ?>"><?= $cel; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
        <?php } ?>
        <?php if (isset($waluty)  && sizeof($waluty) > 0 && trim($waluty[0]) !== '') { ?>
            <div class="paylane-sf-label">
                Wybierz walutę.
            </div> <?php
                    $first = true;
                    foreach ($waluty as $waluta) : ?>
                <div class="paylane-sf-curr-trigger-container">
                    <button class="paylane-sf-currency-button <?= ($first == true ? " selected" : ""); ?>" data-currency="<?= $waluta; ?>"><?= $waluta; ?></button>
                </div>
                <?php
                $first = false;
            endforeach;
        } ?>

        <?php foreach ($kwoty as $kwota) : ?>
            <div class="paylane-sf-trigger-container">
                <button class="paylane-sf-amount-button" data-amount="<?= $kwota; ?>"><?= $kwota + 0; ?></button>
            </div>
        <?php endforeach; ?>
        <?php if ($dowolnaKwota) : ?>
            <div class="paylane-sf-trigger-container">
                <label for="paylane-sf-dowolna-kwota">Dowolna kwota</label>
                <input id="paylane-sf-dowolna-kwota" type="number" step="0.01" class="paylane-sf-amount-button" placeholder="Wprowadź dowolną kwotę">
            </div>
        <?php endif; ?>
        <form class="paylane-sf-widget-form">
            <?php if (isset($regulamin) && trim($regulamin) !== '') : ?>
                <label for="paylane-sf-regulamin"><?= htmlspecialchars_decode($regulamin); ?></label>
                <input id="paylane-sf-regulamin" type="checkbox" class="paylane-sf-amount-checkbox" required>
            <?php endif; ?>
            <button type="submit"><?= $submit ?></button>
        </form>
    </div>
<?php } else { ?>
    <div class="paylane-sf-widget ty-active">
        <?= $podziekowania; ?>
    </div>
<?php } ?>