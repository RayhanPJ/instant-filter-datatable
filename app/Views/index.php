<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CI Test Instant Filter DataTable</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet"
    />
    <style>
        .filters {
          display: flex;
          gap: 1rem;
          align-items: flex-end;
          margin-bottom: 1rem;
          justify-content: flex-end;
        }
        .filters label {
          margin-right: 0.5rem;
        }
        .select2-container {
          width: 200px !important;
        }
      </style>
      
  </head>
  <body>
    <div class="container">
      <div class="filters mt-5">
        <label for="site_code">When Submitted:</label>
        <select id="when_check" class="filter-select"></select>

        <label for="site_code">Site Code:</label>
        <select id="site_code" class="filter-select"></select>

        <label for="mesin_id">Mesin ID:</label>
        <select id="mesin_id" class="form-select"></select>
      </div>

      <br />

      <table id="dataTable" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Submitted By</th>
            <th>Submitted When</th>
            <th>Site Code</th>
            <th>Activity</th>
            <th>UOM</th>
            <th>Block</th>
            <th>Task</th>
            <th>Start</th>
            <th>End</th>
            <th>Mesin ID</th>
            <th>Fuel</th>
            <th>Check By</th>
            <th>When Check</th>
            <th>Verified By</th>
            <th>When Verified</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
            url: "<?php base_url()?>fetch-data",
            type: "GET",
            dataType: "json",
            success: function (data) {
                const table = $("#dataTable").DataTable({
                data: data,
                columns: [
                    { data: "no" },
                    { data: "submitted_by" },
                    { data: "submitted_when" },
                    { data: "site_code" },
                    { data: "activity" },
                    { data: "uom" },
                    { data: "block" },
                    { data: "task" },
                    { data: "start" },
                    { data: "end" },
                    { data: "mesin_id" },
                    { data: "fuel" },
                    { data: "check_by" },
                    { data: "when_check" },
                    { data: "verified_by" },
                    { data: "when_verified" }
                ]
                });

                // collect data for select option filter
                function getDataForFilter(column) {
                return [...new Set(data.map((item) => item[column]))];
                }

                // func append data for select option filter
                function selectFilter(selectId, column) {
                const dataFilter = getDataForFilter(column);
                dataFilter.forEach((value) => {
                    $(selectId).append(new Option(value, value));
                });
                // defind select2
                $(selectId).select2({ placeholder: "Select " + column, allowClear: true });
                }

                // call func selectFilters
                selectFilter("#site_code", "site_code");
                selectFilter("#when_check", "when_check");
                selectFilter("#mesin_id", "mesin_id");

                // event for filter
                $("#when_check").on("change", function () {
                table.columns(2).search(this.value).draw();
                });
                $("#site_code").on("change", function () {
                table.columns(3).search(this.value).draw();
                });
                $("#mesin_id").on("change", function () {
                table.columns(10).search(this.value).draw();
                });
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            }
            });
        });
    </script>
  </body>
</html>
