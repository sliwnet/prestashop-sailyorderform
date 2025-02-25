{extends file='page.tpl'}

{block name='page_content'}
<h2>Uzupełnij dane uczestników</h2>
<form method="post" action="">
    {foreach from=$participants item=participant key=index}
        <fieldset>
            <legend>Uczestnik #{($index+1)}</legend>
            <label>Imię:</label>
            <input type="text" name="participants[{$index}][first_name]" value="{$participant.first_name}" required><br>

            <label>Nazwisko:</label>
            <input type="text" name="participants[{$index}][last_name]" value="{$participant.last_name}" required><br>

            <label>Email:</label>
            <input type="email" name="participants[{$index}][email]" value="{$participant.email}" required><br>

            <label>Telefon:</label>
            <input type="text" name="participants[{$index}][phone]" value="{$participant.phone}" required><br>

            <label>Data urodzenia:</label>
            <input type="date" name="participants[{$index}][birth_date]" value="{$participant.birth_date}" required><br>

            <label>Miejsce urodzenia:</label>
            <input type="text" name="participants[{$index}][birth_place]" value="{$participant.birth_place}" required><br>

            <label>Ulica:</label>
            <input type="text" name="participants[{$index}][street]" value="{$participant.street}" required><br>

            <label>Numer domu:</label>
            <input type="text" name="participants[{$index}][house_number]" value="{$participant.house_number}" required><br>

            <label>Kod pocztowy:</label>
            <input type="text" name="participants[{$index}][postal_code]" value="{$participant.postal_code}" required><br>

            <label>Miejscowość:</label>
            <input type="text" name="participants[{$index}][city]" value="{$participant.city}" required><br>

            <label>
                <input type="checkbox" name="participants[{$index}][can_swim]" value="1"> Potrafię pływać w pław
            </label><br>
        </fieldset>
    {/foreach}
    
    <label>
        <input type="checkbox" name="no_additional_data" value="1"> Nie posiadam danych kolejnych osób
    </label><br>
    
    <label>
        <input type="checkbox" name="data_agreement" value="1" required> Wyrażam zgodę na przetwarzanie danych marketingowych
    </label><br>
    
    <input type="hidden" name="id_order" value="{$id_order}">
    <input type="submit" name="submit_form" value="Zapisz">
</form>

{if isset($smarty.get.success) && $smarty.get.success == 1}
    <p style="color: green;">Dane zostały zapisane poprawnie!</p>
{/if}

{/block}
