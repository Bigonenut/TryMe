            <!--左边布局-->
            <div class="content_left">
                <div class="blog_author">
                    <div class="blog_author">
                        <div class="blog_author_img">
                            <img src="<?php $this->options->博主头像(); ?>">
                        </div>
                    </div>

                    <div class="blog_author_info">
                        <div class="blog_author_name"><?php $this->author(); ?></div>
                        <?php if ($this->options->twitter): ?>
              <a href="<?php $this->options->twitter(); ?>" title="twitter" target="_blank"><i class="iconfont icon-ttww"></i></a>
              <?php endif; ?>
              <?php if ($this->options->weibo): ?>
              <a href="<?php $this->options->weibo(); ?>" title="微博" target="_blank"><i class="iconfont icon-weibo"></i></a>
              <?php endif; ?>
              <?php if ($this->options->github): ?>
              <a href="<?php $this->options->github(); ?>" title="Github" target="_blank"><i class="iconfont icon-github"></i></a>
              <?php endif; ?>
              <?php if ($this->options->telegram): ?>
              <a href="<?php $this->options->telegram(); ?>" title="telegram" target="_blank"><i class="iconfont icon-telegram"></i></a>
              <?php endif; ?>
              <?php if ($this->options->mastodon): ?>
              <a rel="me" href="<?php $this->options->mastodon(); ?>" title="长毛象" target="_blank"><i class="iconfont icon-mastodon"></i></a>
              <?php endif; ?>
              <?php if ($this->options->bilibili): ?>
              <a href="<?php $this->options->bilibili(); ?>" title="哔哩哔哩" target="_blank"><i class="iconfont icon-bilibili"></i></a>
              <?php endif; ?>
              <?php if ($this->options->rss): ?>
              <a href="<?php $this->options->rss(); ?>" title="Rss" target="_blank"><i class="iconfont icon-rss"></i></a>
              <?php endif; ?>
              <?php if ($this->options->douban): ?>
              <a href="<?php $this->options->douban(); ?>" title="豆瓣" target="_blank"><i class="iconfont icon-douban"></i></a>
              <?php endif; ?>
              <?php if ($this->options->zhihu): ?>
              <a href="<?php $this->options->zhihu(); ?>" title="知乎" target="_blank"><i class="iconfont icon-zhihu"></i></a>
              <?php endif; ?>
                    </div>

                </div>

                <div class="tags">
                    <h5 class="tgs_name">标签云</h5>
                    <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=30')->to($tags); ?>
                    <?php if($tags->have()): ?>
                    <?php while ($tags->next()): ?>
                    <a href="<?php $tags->permalink(); ?>"><?php $tags->name(); ?></a>
                    <?php endwhile; ?>
                    <?php endif; ?>

                </div>
            </div>