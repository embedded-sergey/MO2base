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
    const T_SPECIES = 1
    const T_PUBLICATION = 2
    const T_TEMPERATURE = 3
    const T_SALINITY = 4
    const T_DO_LEVEL = 5
    const T_SMR_AVG = 6
    const T_SMR_MIN = 7
    const T_SMR_MAX = 8
    const T_MMR_AVG = 9
    const T_MMR_MIN = 10
    const T_MMR_MAX = 11
    const T_MMR_METHOD = 12
    const T_MASS_AVG = 13
    const T_BR_TEST = 14
    const T_COMMENT = 15
 
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
            
            this.#pages.count = 8 // TODO: remove 
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
            if (this.page+1 < this.#pages.count)
                pages_counter.innerHTML += "..."
            if (this.page != this.#pages.count)
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
                case T_SPECIES:
                    var value = this.#json.data[curent_index].Species
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_PUBLICATION:
                    var value = this.#json.data[curent_index].Publication
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_TEMPERATURE:
                    var value = this.#json.data[curent_index].Temperature
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_SALINITY:
                    var value = this.#json.data[curent_index].Salinity
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_DO_LEVEL:
                    var value = this.#json.data[curent_index].DO_level
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_SMR_AVG:
                    var value = this.#json.data[curent_index].SMR_avg
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_SMR_MIN:
                    var value = this.#json.data[curent_index].SMR_min
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_SMR_MAX:
                    var value = this.#json.data[curent_index].SMR_max
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_MMR_AVG:
                    var value = this.#json.data[curent_index].MMR_avg
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_MMR_MIN:
                    var value = this.#json.data[curent_index].MMR_min
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_MMR_MAX:
                    var value = this.#json.data[curent_index].MMR_max
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_MMR_METHOD:
                    var value = this.#json.data[curent_index].MMR_method
                    if (value == undefined)
                        value = 'no'
                    object = document.createTextNode(value)
                    break
                case T_MASS_AVG:
                    var value = this.#json.data[curent_index].Mass_avg
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_BR_TEST:
                    var value = this.#json.data[curent_index].BR_test
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
                case T_COMMENT:
                    var value = this.#json.data[curent_index].Comment
                    if (value == undefined)
                        value = ''
                    object = document.createTextNode(value)
                    break
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
                if (json_filtered[i].Species == undefined) {
                    SMR_avg.x.push('')
                    SMR_min.x.push('')
                    SMR_max.x.push('')
                    MMR_avg.x.push('')
                    MMR_min.x.push('')
                    MMR_max.x.push('')
                }
                else {
                    SMR_avg.x.push(json_filtered[i].Species)
                    SMR_min.x.push(json_filtered[i].Species)
                    SMR_max.x.push(json_filtered[i].Species)
                    MMR_avg.x.push(json_filtered[i].Species)
                    MMR_min.x.push(json_filtered[i].Species)
                    MMR_max.x.push(json_filtered[i].Species)
                }
                if (json_filtered[i].SMR_avg == undefined) {
                    SMR_avg.y.push(0)
                    MMR_avg.y.push(0)
                }
                else {
                    SMR_avg.y.push(json_filtered[i].SMR_avg)
                    MMR_avg.y.push(json_filtered[i].MMR_avg)
                }
                if (json_filtered[i].SMR_min == undefined) {
                    SMR_min.y.push(0)
                    MMR_min.y.push(0)
                }
                else {
                    SMR_min.y.push(json_filtered[i].SMR_min)
                    MMR_min.y.push(json_filtered[i].MMR_min)
                }
                if (json_filtered[i].SMR_max == undefined) {
                    SMR_max.y.push(0)
                    MMR_max.y.push(0)
                }
                else {
                    SMR_max.y.push(json_filtered[i].SMR_max)
                    MMR_max.y.push(json_filtered[i].MMR_max)
                }

                if (json_filtered[i].Publication == undefined) {
                    SMR_avg.text.push('')
                    MMR_avg.text.push('')
                }
                else {
                    SMR_avg.text.push(json_filtered[i].Publication)
                    MMR_avg.text.push(json_filtered[i].Publication)
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
            // let value = null
            // switch(caller.type)
            // {
            //     case "text":
            //         value = caller.value
            //         break;
            //     default:
            //         console.log("Error: unknown filter type "+ caller.type)
            // }
            
            // this.#filters[caller.id] = value
            this.#filters[caller.id] = caller.value

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
                    table.update(this.responseText)
                    // Disable lock
                    switchLock()       
                }
            })
            xhr.timeout = 4000; // Set timeout to 4 seconds (4000 milliseconds)
            xhr.addEventListener("timeout", function () {
                console.log('Connection timeout')
            })
            // TODO: replace ip by server address
            xhr.open("POST", "http://127.0.0.1:4747/")
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
            table.update() // Gen table for new data
            table.buildPlots() // Build plots
        }
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
            "Species":"fish_1",\
            "Publication":"213/321",\
            "Temperature":24,\
            "Salinity":"0",\
            "DO_level":100,\
            "SMR_avg":120\
        },\
        {\
            "id":2,\
            "Species":"fish_2",\
            "Publication":"213/321",\
            "Temperature":12,\
            "Salinity":"0",\
            "DO_level":100,\
            "SMR_avg":89,\
            "SMR_min":65,\
            "SMR_max":144,\
            "MMR_avg":163,\
            "MMR_min":159,\
            "MMR_max":354,\
            "MMR_method":"Ucrit",\
            "Mass_avg":20,\
            "BR_test":"yes",\
            "Comment":"Fish 2 comment"\
        }\
    ]\
}\
'
        sessionStorage.setItem("fishresp_json", json_text)
        table.update(json_text)
    }
    </script>

    <!-- TODO: move in separate file -->
    <style type="text/css">
        /* Hover for loading data */
        .hover {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            z-index: 1;
            background-color: #90909050;
            visibility: hidden;
            line-height: 100vh;
            font-size: larger;
            text-align: center;
        }

        /* Select/unselect rows for widgets */
        .SelectedRow {
            background-color: yellow;
        }
        .UnselectedRow {
            background-color: #fff;
        }
        
        /* Table parameters */
        table, th, td {
            border: 1px solid;
            height: 1rem;
            /* max-width: 50rem; */
            /* TODO: decide on the size */
        }
        /* Disabled cells for unavailable filters */
        td.disabled {
            background-color: gainsboro;
        }
        /* Disable borders for inputs in filters */
        input.Unbordered{
            border: 0px solid;
            max-width: 5rem;
        }
        
        /* Divs container */
        div.container {
            height: 95vh;
            display: flex;
        }
        div.leftTable {
            width: 70%;
            overflow: auto;
        }
        div.rightPlots {
            width: 30%;
            overflow: auto;
        }
    </style>
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
                        <td>Species</td>
                        <td>Publication</td>
                        <td>Temperature</td>
                        <td>Salinity</td>
                        <td>DO level</td>
                        <td>SMR avg</td>
                        <td>SMR min</td>
                        <td>SMR max</td>
                        <td>MMR avg</td>
                        <td>MMR min</td>
                        <td>MMR max</td>
                        <td>MMR method</td>
                        <td>Mass avg</td>
                        <td>BR test</td>
                        <td>Comment</td>
                    </tr>
                    <tr>
                        <td class="disabled">Filters:</td>
                        <datalist id="Species_list">
                            <!-- todo: make php fill Species list -->
                            <option value="fish_1">
                            <option value="fish_2">
                        </datalist>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_Species" placeholder="Name" list="Species_list"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_Publication" placeholder="DOI"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_Temperature" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_Temperature" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_Salinity" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_Salinity" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_DO level" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_DO level" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_SMR avg" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_SMR avg" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_SMR min" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_SMR min" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_SMR max" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_SMR max" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_MMR avg" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_MMR avg" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_MMR min" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_MMR min" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_MMR max" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_MMR max" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_MMR method" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_MMR method" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_Mass avg" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_Mass avg" placeholder="max"></td>
                        <td><input class="Unbordered" onchange="table.updateFilter(this)" id="filter_BR test" placeholder="min">-<input class="Unbordered" onchange="table.updateFilter(this)" id="filter_BR test" placeholder="max"></td>
                        <td class="disabled"></td>
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
        

    <!-- Debug buttons -->
    <button onclick="uploadTestData()">Upload test data</button>
    <button onclick="switchLock()">Enable hover</button>
    <!-- Hover for loading data -->
    <div id="hover" class="hover">Loading...</div>
</body>
</html>