<?php
/**
 * Front Page Template (Homepage)
 *
 * @package ZK_Futuristic_Theme
 */

get_header();
?>

<style>
/* Additional styles specific to front page */
.hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 1;
    padding-top: 80px;
}

.hero-content {
    text-align: center;
    animation: fadeInUp 1s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.hero-title {
    font-size: clamp(2.5rem, 8vw, 6rem);
    font-weight: 700;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary), var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    background-size: 200% 200%;
    animation: gradientText 5s ease infinite;
}

@keyframes gradientText {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.hero-subtitle {
    font-size: clamp(1.2rem, 3vw, 2rem);
    color: var(--text-muted);
    margin-bottom: 2rem;
    font-family: 'JetBrains Mono', monospace;
}

.typing-text {
    display: inline-block;
    border-right: 3px solid var(--primary);
    padding-right: 5px;
    animation: blink 0.7s infinite;
}

@keyframes blink {
    0%, 50% { border-color: var(--primary); }
    51%, 100% { border-color: transparent; }
}

.hero-description {
    font-size: 1.2rem;
    color: var(--text-muted);
    max-width: 800px;
    margin: 0 auto 3rem;
    line-height: 1.8;
}

.cta-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-secondary {
    background: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.btn-secondary:hover {
    background: rgba(0, 245, 255, 0.1);
    color: var(--primary);
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    pointer-events: none;
}

.shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(40px);
    opacity: 0.3;
    animation: float 20s ease-in-out infinite;
}

.shape:nth-child(1) {
    width: 300px;
    height: 300px;
    background: var(--primary);
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.shape:nth-child(2) {
    width: 400px;
    height: 400px;
    background: var(--secondary);
    top: 50%;
    right: 10%;
    animation-delay: 5s;
}

.shape:nth-child(3) {
    width: 250px;
    height: 250px;
    background: var(--accent);
    bottom: 10%;
    left: 30%;
    animation-delay: 10s;
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(50px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-50px, 50px) scale(0.9);
    }
}

section.content-section {
    padding: 120px 0;
    position: relative;
    z-index: 1;
}

.section-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    text-align: center;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-subtitle {
    text-align: center;
    color: var(--text-muted);
    font-size: 1.2rem;
    margin-bottom: 4rem;
}

@media (max-width: 640px) {
    .cta-buttons {
        flex-direction: column;
    }
}
</style>

<main id="primary" class="site-main">

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <div class="hero-content">
            <h1 class="hero-title"><?php bloginfo('name'); ?></h1>
            <p class="hero-subtitle"><span class="typing-text" id="typing-text"></span></p>
            <p class="hero-description">
                <?php
                $description = get_bloginfo('description');
                if ($description) {
                    echo esc_html($description);
                } else {
                    echo 'Architecting the future of cloud infrastructure at AWS. Building scalable, serverless, and AI-powered solutions that transform complex cloud technologies into accessible developer experiences.';
                }
                ?>
            </p>
            <div class="cta-buttons">
                <a href="#content" class="btn btn-primary">Explore Content</a>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-secondary">Let's Connect</a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section id="content" class="content-section">
        <div class="container">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('content-card'); ?>>
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('full', array('class' => 'featured-image'));
                    }
                    ?>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'zk-futuristic'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>
                <?php
            endwhile;
            ?>
        </div>
    </section>

</main><!-- #main -->

<script>
// Typing Animation for Hero
(function() {
    const typingText = document.getElementById('typing-text');
    if (!typingText) return;

    const texts = [
        'Senior DevOps Engineer at AWS',
        'Cloud Infrastructure Specialist',
        'AI/ML Enthusiast',
        'Open Source Contributor'
    ];
    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    function typeText() {
        const currentText = texts[textIndex];

        if (!isDeleting && charIndex <= currentText.length) {
            typingText.textContent = currentText.substring(0, charIndex);
            charIndex++;
            setTimeout(typeText, 100);
        } else if (isDeleting && charIndex >= 0) {
            typingText.textContent = currentText.substring(0, charIndex);
            charIndex--;
            setTimeout(typeText, 50);
        } else if (!isDeleting && charIndex === currentText.length + 1) {
            setTimeout(function() {
                isDeleting = true;
                typeText();
            }, 2000);
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            textIndex = (textIndex + 1) % texts.length;
            setTimeout(typeText, 500);
        }
    }

    typeText();
})();
</script>

<?php
get_footer();
