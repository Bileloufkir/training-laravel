<?php

function sortByColumn($column, $label, $input = [], $enabled = true)
{
    if (!$enabled || empty($input['sort_by']) || empty($input['sort_dir'])) {
        return $label;
    }

    $sort_by = $input['sort_by'];
    $sort_dir = $input['sort_dir'];

    $icon_dir = '';
    if ($sort_by == $column && $sort_dir) {
        $sort_dir = ($sort_dir == 'asc') ? 'desc' : 'asc';
        $icon_dir = ($sort_dir == 'asc') ? 'fa-sort-amount-down' : 'fa-sort-amount-down-alt';
        $input['sort_dir'] = $sort_dir;
    }
    else
    {
        $input['sort_by'] = $column;
        $input['sort_dir'] = $sort_dir;
    }

    if ($icon_dir) {
        $icon_dir = "&nbsp;<i class=\"fas {$icon_dir} float-right\">";
    }

    $input = http_build_query($input);

    return "<a href=\"?{$input}\">{$label}</a>{$icon_dir}</i>";

}
