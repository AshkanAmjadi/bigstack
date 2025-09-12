<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($list as $subject)
        <url>
            <loc>{{ urldecode(route('project.show',['project' => $subject->slug])) }}</loc>
            <lastmod>{{  $subject->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>yearly</changefreq>
            <priority>0.8</priority>
            @if($subject->img)
                <image:image>
                    <image:loc>{{ semanticImgUrlMaker($subject,'img',false) }}</image:loc>
                    <image:title>{{ $subject->page_title }}</image:title>
                </image:image>
            @endif
            @if($subject->banner)
                <image:image>
                    <image:loc>{{ semanticImgUrlMaker($subject,'banner',false) }}</image:loc>
                    <image:title>{{ $subject->page_title }}</image:title>
                </image:image>
            @endif
            @if($subject->mobile_banner)
                <image:image>
                    <image:loc>{{ semanticImgUrlMaker($subject,'mobile_banner',false) }}</image:loc>
                    <image:title>{{ $subject->page_title }}</image:title>
                </image:image>
            @endif
        </url>
    @endforeach

</urlset>
