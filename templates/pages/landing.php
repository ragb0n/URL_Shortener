<div>
    <h3>Wpisz adres do skrócenia</h3>
    <div>
        <form class="note-form" action="/proj1/?action=landing" method="post">
         <!-- po submitowaniu formularze, dane z niego zostaną przekazane do miejsca/pliku wskazanego w action, oraz zapisane w tablicy globalnej POST -->
            <ul>
                <li>
                    <label>Adres URL do skrócenia</label>
                    <input type="url" name="beforeURL" class="field-long" required />
                </li>
                <li>
                    <input type="submit" value="Skróć" />
                </li>
            </ul>
        </form>
    </div>
</div>