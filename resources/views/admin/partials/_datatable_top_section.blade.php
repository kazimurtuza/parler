<div class="show-entry-wrapper">
    <select class="showEntries default-select" onchange="showEntries(this, '{{ $table_id }}')">
        <option value="10">10 / Page</option>
        <option value="25">25 / Page</option>
        <option value="50">50 / Page</option>
        <option value="100">100 / Page</option>
    </select>
</div>
@if(isset($import_button) && ($import_button == 'show'))
    <div>
        <button class="btn btn-export xlimport" type="button"><i class="fa fa-upload"></i> Import</button>
    </div>
@endif
<div class="dt-custom-buttons">
    <button type="button" class="btn btn-export" onclick="exportData('#{{ $table_id }}')">
        <i class="fas fa-download"></i> Export
    </button>
</div>
<div class="search-container">
    <input class="search datatable-search" id="searchleft" oninput="tableFilter(this, '{{ $table_id }}')" type="search" name="q" placeholder="Search">
    <label class="button searchbutton" for="searchleft"><span class="mglass">&#9906;</span></label>
</div>
