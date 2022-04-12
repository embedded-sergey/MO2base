<?php
// Connect to database
require_once 'database.php';

// Request table header
$db_request = 'SELECT td.id, td.json_ident, td.caption, td.filter_placeholder,
f.html_code,
cell.code
FROM table_data td
LEFT JOIN filters f on f.id = td.filter_id
LEFT JOIN js_cellcode cell on cell.id = td.js_cellcode_id';
// Exec request
$table_data = $DB->query($db_request)->fetchAll();
?>
<html>
<head>
    <meta charset="UTF-8">
    <!-- Plot library -->
    <script src='https://cdn.plot.ly/plotly-2.9.0.min.js'></script>

    <!-- TODO: move in separate file -->
    <script>

    // Table size
    const TABLE_ROWS = 50
    const TABLE_COLUMS = 16

    // Define rows names for create-switches
    const T_CHECKBOX = 0
<?php foreach($table_data as $row): ?>
    const T_<?=strtoupper($row['json_ident'])?> = <?=$row['id']?>

<?php endforeach ?>
 
    // Class for table data
    class Table {
        
        #json = {count: 0, data: []} // private field, contains json data

        #checkedRows = [] // list contain selected rows by json indexes TODO: save between page refresh

        #pages = {current: 1, count: 1} // dict contain page data

        #filters = {} // dict contain filters values

        // Method to update json data
        parse_json(data) {
            if(data) {
                // Remove unchecked rows in table
                this.#json.data = this.#json.data.filter(element => table.#checkedRows.includes(element.id))
                // Parse new data
                var new_json = JSON.parse(data);
                // if old json data contains elements
                if (this.#json.data.length)
                    // Remove duplicates with old checked data
                    new_json.data = new_json.data.filter(element => !this.#checkedRows.includes(element.id))
                // Append new to old values
                this.#json.data = this.#json.data.concat(new_json.data)
                // Calc new lenght
                this.#json.count = this.#json.data.length
                // Save data
                sessionStorage.setItem("fishresp_json", JSON.stringify(this.#json))
            }
        }

        // Method to restore saved checkedRows
        restore_checkedRows() {
            let fishresp_checkedRows = sessionStorage.getItem("fishresp_checkedRows")
            if (fishresp_checkedRows) {
                this.#checkedRows = JSON.parse('[' + fishresp_checkedRows + ']')
            }
        }

        // Method to select/deselect rows by json indexes
        row_switcher(checkbox) {
            // Getting table for filling
            var html_table = document.getElementById("table")

            if (html_table.children[checkbox.name].className == 'SelectedRow') {
                // Remove selection color
                html_table.children[checkbox.name].className = 'UnselectedRow'
                // Remove row from selected rows list
                this.#checkedRows = this.#checkedRows.filter(element => element != parseInt(checkbox.value))
            }
            else {
                // Set selection color
                html_table.children[checkbox.name].className = 'SelectedRow'
                // Add row to selected rows list
                this.#checkedRows.push(parseInt(checkbox.value))
            }
            // Save selected rows
            sessionStorage.setItem("fishresp_checkedRows", this.#checkedRows)
            // Update plots
            this.buildPlots()
        }

        // Update page counter
        pageCouter() {
            // Calc pages count
            this.#pages.count = parseInt(this.#json.count / TABLE_ROWS)
            if (this.#json.count % TABLE_ROWS > 0)
                this.#pages.count++
            
            // Gen html code
            var pages_counter = document.getElementById('pages_counter')
            pages_counter.innerHTML = ""
            if (this.#pages.current > 1)
                pages_counter.innerHTML = "<a onclick='table.selectPage(1)'>1</a>"
            if (this.#pages.current > 3)
                pages_counter.innerHTML += "..."
            if ((this.#pages.current-1) > 1)
                pages_counter.innerHTML += "<a onclick='table.selectPage("+(this.#pages.current-1)+")'>"+(this.#pages.current-1)+"</a>"
            pages_counter.innerHTML += "<a style='font-weight:bold;' onclick='table.selectPage("+this.#pages.current+")'>"+this.#pages.current+"</a>"
            if ((this.#pages.current+1) < this.#pages.count)
                pages_counter.innerHTML += "<a onclick='table.selectPage("+(this.#pages.current+1)+")'>"+(this.#pages.current+1)+"</a>"
            if (this.#pages.current+1 < this.#pages.count)
                pages_counter.innerHTML += "..."
            if (this.#pages.current < this.#pages.count)
                pages_counter.innerHTML += "<a onclick='table.selectPage("+this.#pages.count+")'>"+this.#pages.count+"</a>"
        }
        // Select page
        selectPage(page) {
            this.#pages.current = page // Remember the memory page

            // Getting table for filling
            var html_table = document.getElementById("table")
            // Cleanup old data
            while(html_table.hasChildNodes())
                html_table.removeChild(html_table.firstChild);
        
            // Calc current index for selected page
            var curent_index = (this.#pages.current-1) * TABLE_ROWS

            // Fill table
            for (let row = 0; row < TABLE_ROWS; row++) {
                var current_row = html_table.insertRow(row)
                current_row.className = 'UnselectedRow'
                for (let column = 0; column < TABLE_COLUMS; column++) {
                    var current_column = current_row.insertCell(column)
                    if (curent_index < this.#json.count)
                        current_column.appendChild(this.fill_table_cell(column, row, curent_index))
                }
                curent_index++
            }       
            this.pageCouter() // Update page counter
        }

        // Update table data, when new json received
        update(json_data) {
            this.parse_json(json_data) // Parse and store json values
            this.selectPage(1) // Fill first table page  
        }

        // Fill table cell with indexes
        fill_table_cell(column, row, curent_index) {
            var object = null
            var html_table = document.getElementById("table")
            // Create object for column
            switch (column) {
                case T_CHECKBOX:
                    object = document.createElement("input");
                    object.type = "checkbox";
                    object.name = row
                    object.value = this.#json.data[curent_index].id;
                    object.id = "id" + column + "_" + row;
                    // object.name = "name" + json.items[i].name;
                    // On change function
                    object.onchange = function() {
                        table.row_switcher(object)
                    }
                    
                    // Checking if selecting this row is needed
                    if (this.#checkedRows.includes(parseInt(object.value))) {
                        object.checked = true
                        html_table.children[object.name].className = 'SelectedRow'
                    }
                    break
// Gen. cells with table_data parameters
<?php foreach($table_data as $row): ?>
                case T_<?=strtoupper($row['json_ident'])?>:
                    <?=str_replace('%JSON_ID%', $row['json_ident'], $row['code'])?>

                    break
<?php endforeach ?>
                // Empty by default
                default:
                    object = document.createTextNode("")
            } 
            return object
        }

        // Build plot on selected rows
        buildPlots() {
            // Filter selected rows in json data
            var json_filtered = this.#json.data.filter(element => this.#checkedRows.includes(element.id))

            var SMR_min = {
                x: [],
                y: [],
                name: 'SMR min',
                type: 'bar',
                marker: {
                    color: 'rgb(0,124,0)'
                }
            };
            var SMR_avg = {
                x: [],
                y: [],
                text: [],
                name: 'SMR avg',
                type: 'bar',
                marker: {
                    color: 'rgb(142,124,195)'
                }
            };
            var SMR_max = {
                x: [],
                y: [],
                name: 'SMR max',
                type: 'bar',
                marker: {
                    color: 'rgb(142,0,0)'
                }
            };

            var MMR_min = {
                x: [],
                y: [],
                name: 'MMR min',
                type: 'bar',
                marker: {
                    color: 'rgb(0,124,0)'
                }
            };
            var MMR_avg = {
                x: [],
                y: [],
                text: [],
                name: 'MMR avg',
                type: 'bar',
                marker: {
                    color: 'rgb(142,124,195)'
                }
            };
            var MMR_max = {
                x: [],
                y: [],
                name: 'MMR max',
                type: 'bar',
                marker: {
                    color: 'rgb(142,0,0)'
                }
            };
            
            for (let i = 0; i < json_filtered.length; i++) {
                if (json_filtered[i].species == undefined) {
                    SMR_avg.x.push('')
                    SMR_min.x.push('')
                    SMR_max.x.push('')
                    MMR_avg.x.push('')
                    MMR_min.x.push('')
                    MMR_max.x.push('')
                }
                else {
                    SMR_avg.x.push(json_filtered[i].species)
                    SMR_min.x.push(json_filtered[i].species)
                    SMR_max.x.push(json_filtered[i].species)
                    MMR_avg.x.push(json_filtered[i].species)
                    MMR_min.x.push(json_filtered[i].species)
                    MMR_max.x.push(json_filtered[i].species)
                }

                if (json_filtered[i].smr_avg == undefined) {
                    SMR_avg.y.push(0)
                }
                else {
                    SMR_avg.y.push(json_filtered[i].smr_avg)
                }
                if (json_filtered[i].smr_min == undefined) {
                    SMR_min.y.push(0)
                }
                else {
                    SMR_min.y.push(json_filtered[i].smr_min)
                }
                if (json_filtered[i].smr_max == undefined) {
                    SMR_max.y.push(0)
                }
                else {
                    SMR_max.y.push(json_filtered[i].smr_max)
                }
                if (json_filtered[i].mmr_avg == undefined) {
                    MMR_avg.y.push(0)
                }
                else {
                    MMR_avg.y.push(json_filtered[i].mmr_avg)
                }
                if (json_filtered[i].mmr_min == undefined) {
                    MMR_min.y.push(0)
                }
                else {
                    MMR_min.y.push(json_filtered[i].mmr_min)
                }
                if (json_filtered[i].mmr_max == undefined) {
                    MMR_max.y.push(0)
                }
                else {
                    MMR_max.y.push(json_filtered[i].mmr_max)
                }

                if (json_filtered[i].publication == undefined) {
                    SMR_avg.text.push('')
                    MMR_avg.text.push('')
                }
                else {
                    SMR_avg.text.push(json_filtered[i].publication)
                    MMR_avg.text.push(json_filtered[i].publication)
                }

            }

            var SMR_data = [SMR_min, SMR_avg, SMR_max];
            var MMR_data = [MMR_min, MMR_avg, MMR_max];
            var layout = {barmode: 'stack'};
            Plotly.newPlot('SMR', SMR_data, layout);
            Plotly.newPlot('MMR', MMR_data, layout);
        }

        // Update fiters dict
        updateFilter(caller) {
            // this.#filters[caller.id] = value
            if (caller.value.length > 0)
                this.#filters[caller.id] = caller.value
            else
                delete this.#filters[caller.id]
            // Load data with new filters
            this.loadData()
        }

        // Request data from server
        loadData() {
            // Enable lock
            switchLock()

            // Sync request
            var xhr = new XMLHttpRequest()
            xhr.addEventListener("readystatechange", function () {
                if (this.readyState === 4) {
                    // console.log(this.responseText)
                    table.update(this.responseText)
                    // Disable lock
                    switchLock()       
                }
            })
            xhr.timeout = 4000; // Set timeout to 4 seconds (4000 milliseconds)
            xhr.addEventListener("timeout", function () {
                console.log('Connection timeout')
            })
            xhr.open("POST", "/filters.php")
            xhr.send(JSON.stringify(this.#filters))
        }
    } 

    let table = new Table

    // Function to initialize filters and autosave 
    function init() {
        fishresp_json = sessionStorage.getItem("fishresp_json")
        // if has autosave
        if (fishresp_json) {
            table.restore_checkedRows() // Restore the contents of checked rows 
            table.update(fishresp_json) // Restore the contents of json data
            table.buildPlots() // Build plots
        }
        else
        {
            table.loadData() // Request server for new data
            table.update() // Gen empty table if nothing loaded
            table.buildPlots() // Build plots
        }

        // Set selects options
        set_mmr_methods()
        set_br_test()
    }

    // init mmr_methods select options
    function set_mmr_methods() {
        select = document.getElementById('mmr_method')
        var opt
        <?php
            // Request mmr_methods list from DB
            $stmt = $DB->query("SELECT * FROM mmr_method;");
            while ($row = $stmt->fetch())
            {
                echo '
        opt = document.createElement("option")
        opt.value = "' . $row['name'] . '"
        opt.innerHTML = "' . $row['name'] . '"
        select.appendChild(opt)';
            }
        ?>

    }

    // init br_test select options
    function set_br_test() {
        select = document.getElementById('br_test');
        var opt 
        <?php
            // Request br_test list from DB
            $stmt = $DB->query("SELECT * FROM br_test;");
            while ($row = $stmt->fetch())
            {
                echo '
        opt = document.createElement("option");
        opt.value = "' . $row['name'] . '";
        opt.innerHTML = "' . $row['name'] . '";
        select.appendChild(opt)';
            }
        ?>
    }
    
    // function to block the page while loading
    function switchLock(){
        // Hover for loading data
        let hover = document.getElementById("hover")

        if (hover.style.visibility != "visible")
            hover.style.visibility = "visible"
        else
            hover.style.visibility = "hidden"
    }

    function uploadTestData() {
        // Test data
        var json_text = '\
{\
    "count":2,\
    "data":[\
        {\
            "id":1,\
            "species":"fish_1",\
            "publication":"213/321",\
            "temperature":24,\
            "salinity":"0",\
            "do_level":100,\
            "smr_avg":120\
        },\
        {\
            "id":2,\
            "species":"fish_2",\
            "publication":"213/321",\
            "temperature":12,\
            "salinity":"0",\
            "do_level":100,\
            "smr_avg":89,\
            "smr_min":65,\
            "smr_max":144,\
            "mmr_avg":163,\
            "mmr_min":159,\
            "mmr_max":354,\
            "mmr_method":"Ucrit",\
            "mass_avg":20,\
            "br_test":"yes",\
            "comment":"Fish 2 comment"\
        }\
    ]\
}\
'
        sessionStorage.setItem("fishresp_json", json_text)
        table.update(json_text)
    }
    </script>

    <link rel="stylesheet"href="css/styles.css">
</head>
<body onload="init()">
    <div class="container">
        <div class="leftTable">
            <!-- Table for respirometry -->
            <table>
                <!-- Header with filters -->
                <tbody>
                    <tr>
                        <td>Select</td>
<!-- Set table captions -->
<?php foreach($table_data as $row): ?>
                            <td><?=$row['caption']?></td>
<?php endforeach ?>
                    </tr>
                    <tr>
                        <td class="disabled">Filters:</td>
                        <!-- datalist for species filter -->
                        <datalist id="species_list">
                            <?php
                                // Request species list from DB
                                $stmt = $DB->query("SELECT name FROM species;");
                                while ($row = $stmt->fetch())
                                {
                                    echo '<option value="' . $row['name'] . '">';
                                }
                            ?>
                        </datalist>
                        <!-- Gen. filters for every column -->
                        <?php
                        $tags = array('%ID%', '%PLACEHOLDER%'); 
                        foreach($table_data as $row) 
                        {
                            $values = array($row['json_ident'], $row['filter_placeholder']);
                            echo '<td>' . str_replace($tags, $values, $row['html_code']) . '</td>';
                        }
                        ?>
                        </form>
                    </tr>
                </tbody>

                <!-- Dynamicaly filled rows -->
                <tbody id="table"></tbody>
            </table>
        </div>
        <div class="rightPlots">
            <!-- Charts section -->
            <div id='SMR'></div>
            <div id='MMR'></div>
        </div>
    </div>
    <!-- Dynamicaly filled pages counter -->
    <div id="pages_counter"></div>
        
    <!-- Hover for loading data -->
    <div id="hover" class="hover">Loading...</div>
</body>
</html>