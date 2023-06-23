<% if $Image %>
    <% if $ShowTitle %>
        <h2>$Title</h2>
    <% end_if %>
    <div class="image">
        {$Image}
    </div>
    <% if $Caption %>
        <p class="caption">{$Caption}</p>
    <% end_if %>
<% end_if %>
