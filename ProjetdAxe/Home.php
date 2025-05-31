<?php

require_once("haut_page.php");

?>

    <!-- Haut de la page, bannière de présentation -->
    <header class="banner">
        <img src="images/League-of-Legends-Logo.png" alt="League of Legends">
        <h1>Trading Cards Game</h1>
        <div class="button">
            <a href="#functionalities" class="banner-button">
                <div>Get Started</div>
                <img src="images/Arrow.png" alt="go to">
            </a>
        </div>
    </header>

    <!-- Swiper présentant les différentes fonctionnalités avec une images et un titre -->
    <section class="functionalities" id="functionalities">
        <h2>Functionalities</h2>
        <div class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="images/Collection.png" alt="Collection">
                    <div class="text-overlay">Collection Tracker</div>
                </div>
                <div class="swiper-slide"><img src="images/TradingCardsBooster.png" alt="Trading Cards Booster">
                    <div class="text-overlay">Open Boosters</div>
                </div>
                <div class="swiper-slide"><img src="images/Sorting-and-Favorite.png" alt="Sorting and Favorite">
                    <div class="text-overlay">Sorting & Favorite</div>
                </div>
                <div class="swiper-slide"><img src="images/Trading.png" alt="Trading">
                    <div class="text-overlay">Trading</div>
                </div>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- Détails des fontionnalités -->
    <section>
        <h2>Details</h2>
        <div class="details">
            <div class="image"><img src="images/Collection.png" alt="Cards Collection"></div>
            <div class="container">
                <h3>Collection Tracker</h3>
                <p>Save your progress and aim to collect every card in the game.</p>
                <a href="Collection.php">
                    <button class="details-button">
                        <div>Start your collection</div>
                        <img src="images/Arrow.png" alt="go to">
                    </button>
                </a>
            </div>
        </div>
        <div class="details">
            <div class="container">
                <h3>Open Boosters</h3>
                <p>Open one booster every 24 hours to add new cards to your collection and discover rare champions.</p>
                <a href="Booster.php">
                    <button class="details-button">
                        <div>Open a booster</div>
                        <img src="images/Arrow.png" alt="go to">
                    </button>
                </a>
            </div>
            <div class="image"><img src="images/TradingCardsBooster.png" alt="Trading Cards Booster"></div>
        </div>
        <div class="details">
            <div class="image"><img src="images/Sorting-and-Favorite.png" alt="Sorting and Favorite"></div>
            <div class="container">
                <h3>Sorting and Favorite</h3>
                <p>Use filters and mark favorites to quickly find the cards you care about the most.</p>
                <a href="Collection.php">
                    <button class="details-button">
                        <div>Start your collection</div>
                        <img src="images/Arrow.png" alt="go to">
                    </button>
                </a>
            </div>
        </div>
        <div class="details">
            <div class="container">
                <h3>Trading</h3>
                <p>Trade cards with other players to complete your collection and get the ones you’re missing.</p>
                <a href="Trading.php">
                    <button class="details-button">
                        <div>Start trading</div>
                        <img src="images/Arrow.png" alt="go to">
                    </button>
                </a>
            </div>
            <div class="image"><img src="images/Trading.png" alt="Trading"></div>
        </div>
    </section>

    <!-- Déposer un feedback pour améliorer le site web -->
    <section class="feedback">
        <h2>Feedback</h2>
        <p>Your feedback helps me improve the experience. Let me know what you enjoy and what could be better !</p>
        <button class="feedback-button">
            <div>Leave feedback</div>
            <img src="images/Arrow.png" alt="go to">
        </button>
    </section>

<?php

require_once("bas_page.php");

?>