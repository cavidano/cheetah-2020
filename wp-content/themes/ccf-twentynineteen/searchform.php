<form action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Search" id="search-form" method="get" role="search" >
    <div class="input-group">
        <label class="sr-only" for="search-site">Search</label>
        <input class="form-control form-control-sm" name="s" placeholder="Search" id="search-site">
        <button type="submit" form="search-form" value="submit" class="btn btn-link btn-sm">
            <span class="sr-only">
                Search
            </span>
            <span class="fas fa-search text-body"></span>
        </button>
    </div>
</form>