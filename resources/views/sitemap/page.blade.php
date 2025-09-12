<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($list as $subject)
        <url>
            <loc>{{ urldecode(route('page.show',['page' => $subject->slug])) }}</loc>
            <lastmod>{{  $subject->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>yearly</changefreq>
            <priority>1</priority>

        </url>
    @endforeach

</urlset>
