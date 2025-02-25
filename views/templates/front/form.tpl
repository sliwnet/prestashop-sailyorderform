{extends file='page.tpl'}

{block name='page_content'}
<h2>Uzupełnij dane uczestnika</h2>
<form method="post" action="">
    <label>Imię:</label>
    <input type="text" name="first_name" value="{$first_name}" required><br>

    <label>Nazwisko:</label>
    <input type="text" name="last_name" value="{$last_name}" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="{$email}" required><br>

    <label>Telefon:</label>
    <input type="text" name="phone" value="{$phone}" required><br>

    <label>Data urodzenia:</label>
    <input type="date" name="birth_date" value="{$birth_date}" required><br>

    <label>Miejsce urodzenia:</label>
    <input type="text" name="birth_place" value="{$birth_place}" required><br>

    <label>Ulica:</label>
    <input type="text" name="street" value="{$street}" required><br>

    <label>Numer domu:</label>
    <input type="text" name="house_number" value="{$house_number}" required><br>

    <label>Kod pocztowy:</label>
    <input type="text" name="postal_code" value="{$postal_code}" required><br>

    <label>Miejscowość:</label>
    <input type="text" name="city" value="{$city}" required><br>

    <input type="hidden" name="id_order" value="{$id_order}">

    <label>
        <input type="checkbox" name="can_swim" value="1" {if $can_swim}checked{/if}> Potrafię pływać w pław
    </label><br>

    <label>
        <input type="checkbox" name="data_agreement" value="1" required> Wyrażam zgodę na przetwarzanie danych
    </label><br>

    <input type="submit" name="submit_form" value="Zapisz">
</form>

{if isset($smarty.get.success) && $smarty.get.success == 1}
    <p style="color: green;">Dane zostały zapisane poprawnie!</p>
{/if}

{/block}
