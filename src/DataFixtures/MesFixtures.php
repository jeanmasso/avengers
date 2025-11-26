<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Bookmark;
use App\Entity\Tag;
use App\Entity\Faune;
use App\Entity\Flore;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixtures personnalisées pour peupler la base de données avec des données de démonstration
 *
 * Cette classe charge un ensemble complet de données de test incluant :
 * - 25 tags (mots-clés technologiques)
 * - 20 bookmarks avec 2 à 5 tags aléatoires
 * - 15 livres avec leurs auteurs (certains auteurs ont plusieurs livres)
 * - 5 éléments de faune (animaux)
 * - 5 éléments de flore (plantes)
 *
 * Commande d'exécution : php bin/console doctrine:fixtures:load
 */
class MesFixtures extends Fixture
{
    /**
     * Charge toutes les données de test dans la base de données
     *
     * @param ObjectManager $manager Gestionnaire d'entités Doctrine
     */
    public function load(ObjectManager $manager): void
    {
        // ===== 1. Création de 25 mots-clés =====
        $tagNames = [
            'PHP', 'JavaScript', 'Python', 'Java', 'Symfony', 'React', 'Vue.js',
            'Angular', 'Laravel', 'Django', 'Spring', 'Node.js', 'Docker', 'Kubernetes',
            'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'AWS', 'Azure', 'Git',
            'DevOps', 'CI/CD', 'API', 'REST'
        ];

        $tags = [];
        foreach ($tagNames as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            $manager->persist($tag);
            $tags[] = $tag;
        }

        // ===== 2. Création de marque-pages avec 2 à 5 tags aléatoires =====
        $bookmarksData = [
            ["url" => "https://symfony.com/", "comment" => "Framework PHP Symfony"],
            ["url" => "https://www.php.net/", "comment" => "Documentation PHP officielle"],
            ["url" => "https://react.dev/", "comment" => "React - Bibliothèque JavaScript"],
            ["url" => "https://vuejs.org/", "comment" => "Vue.js Framework"],
            ["url" => "https://angular.io/", "comment" => "Angular Framework"],
            ["url" => "https://nodejs.org/", "comment" => "Node.js Runtime"],
            ["url" => "https://www.docker.com/", "comment" => "Docker - Containerization"],
            ["url" => "https://kubernetes.io/", "comment" => "Kubernetes - Orchestration"],
            ["url" => "https://www.mysql.com/", "comment" => "MySQL Database"],
            ["url" => "https://www.postgresql.org/", "comment" => "PostgreSQL Database"],
            ["url" => "https://www.mongodb.com/", "comment" => "MongoDB - NoSQL Database"],
            ["url" => "https://redis.io/", "comment" => "Redis - Cache"],
            ["url" => "https://aws.amazon.com/", "comment" => "Amazon Web Services"],
            ["url" => "https://azure.microsoft.com/", "comment" => "Microsoft Azure"],
            ["url" => "https://git-scm.com/", "comment" => "Git - Version Control"],
            ["url" => "https://github.com/", "comment" => "GitHub Platform"],
            ["url" => "https://getbootstrap.com/", "comment" => "Bootstrap CSS Framework"],
            ["url" => "https://tailwindcss.com/", "comment" => "Tailwind CSS"],
            ["url" => "https://laravel.com/", "comment" => "Laravel PHP Framework"],
            ["url" => "https://www.djangoproject.com/", "comment" => "Django Python Framework"]
        ];

        foreach ($bookmarksData as $data) {
            $bookmark = new Bookmark();
            $bookmark->setUrl($data["url"]);
            $bookmark->setComment($data["comment"]);
            $bookmark->setCreatedDate(new \DateTime());

            // Ajouter aléatoirement entre 2 et 5 tags
            $nbTags = mt_rand(2, 5);
            $randomTags = (array) array_rand($tags, $nbTags);
            foreach ($randomTags as $index) {
                $bookmark->addTag($tags[$index]);
            }

            $manager->persist($bookmark);
        }

        // ===== 3. Création des auteurs et livres (un auteur par livre) =====
        $booksData = [
            ["author_firstname" => "Victor", "author_lastname" => "Hugo", "title" => "Les Misérables", "year" => "1862"],
            ["author_firstname" => "Victor", "author_lastname" => "Hugo", "title" => "Notre-Dame de Paris", "year" => "1831"],
            ["author_firstname" => "Émile", "author_lastname" => "Zola", "title" => "Germinal", "year" => "1885"],
            ["author_firstname" => "Émile", "author_lastname" => "Zola", "title" => "L'Assommoir", "year" => "1877"],
            ["author_firstname" => "Albert", "author_lastname" => "Camus", "title" => "L'Étranger", "year" => "1942"],
            ["author_firstname" => "Albert", "author_lastname" => "Camus", "title" => "La Peste", "year" => "1947"],
            ["author_firstname" => "Gustave", "author_lastname" => "Flaubert", "title" => "Madame Bovary", "year" => "1857"],
            ["author_firstname" => "Honoré", "author_lastname" => "de Balzac", "title" => "Le Père Goriot", "year" => "1835"],
            ["author_firstname" => "Alexandre", "author_lastname" => "Dumas", "title" => "Les Trois Mousquetaires", "year" => "1844"],
            ["author_firstname" => "Jules", "author_lastname" => "Verne", "title" => "Vingt Mille Lieues sous les mers", "year" => "1870"],
            ["author_firstname" => "Molière", "author_lastname" => "", "title" => "Le Misanthrope", "year" => "1666"],
            ["author_firstname" => "Jean-Paul", "author_lastname" => "Sartre", "title" => "La Nausée", "year" => "1938"],
            ["author_firstname" => "Simone", "author_lastname" => "de Beauvoir", "title" => "Le Deuxième Sexe", "year" => "1949"],
            ["author_firstname" => "Marcel", "author_lastname" => "Proust", "title" => "Du côté de chez Swann", "year" => "1913"],
            ["author_firstname" => "Stendhal", "author_lastname" => "", "title" => "Le Rouge et le Noir", "year" => "1830"]
        ];

        $authors = [];
        foreach ($booksData as $data) {
            // Chercher ou créer l'auteur
            $authorKey = $data["author_firstname"] . " " . $data["author_lastname"];
            if (!isset($authors[$authorKey])) {
                $author = new Author();
                $author->setFirstname($data["author_firstname"]);
                $author->setLastname($data["author_lastname"]);
                $manager->persist($author);
                $authors[$authorKey] = $author;
            }

            $book = new Book();
            $book->setTitle($data["title"]);
            $book->setYear($data["year"]);
            $book->setAuthor($authors[$authorKey]);
            $manager->persist($book);
        }

        // ===== 4. Création du contenu de la rubrique Le Cailloux - Faune =====
        $fauneData = [
            [
                "name" => "Renard roux",
                "photo_url" => "https://images.unsplash.com/photo-1474511320723-9a56873867b5?w=400",
                "description" => "Le renard roux est un mammifère carnivore de la famille des canidés. Très adaptatif, il vit dans diverses régions du monde et est reconnaissable à sa fourrure rousse et sa queue touffue."
            ],
            [
                "name" => "Mésange bleue",
                "photo_url" => "https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=400",
                "description" => "La mésange bleue est un petit passereau au plumage bleu et jaune éclatant. Elle est très commune dans les jardins européens et se nourrit principalement d'insectes et de graines."
            ],
            [
                "name" => "Écureuil roux",
                "photo_url" => "https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=400",
                "description" => "L'écureuil roux est un petit rongeur arboricole au pelage roux orangé. Agile et vif, il se nourrit de graines, noisettes et glands qu'il stocke pour l'hiver."
            ],
            [
                "name" => "Chevreuil",
                "photo_url" => "https://images.unsplash.com/photo-1551197193-12d6-bc9b-e9c6-3a43a62a2cf3?w=400",
                "description" => "Le chevreuil est un cervidé élégant et discret qui vit dans les forêts. Il est reconnaissable à sa petite taille et ses bois chez le mâle."
            ],
            [
                "name" => "Hérisson d'Europe",
                "photo_url" => "https://images.unsplash.com/photo-1584714268709-c3dd9c92b378?w=400",
                "description" => "Le hérisson d'Europe est un petit mammifère insectivore couvert de piquants. Nocturne, il se nourrit d'insectes, de limaces et d'escargots."
            ]
        ];

        foreach ($fauneData as $data) {
            $faune = new Faune();
            $faune->setName($data["name"]);
            $faune->setPhotoUrl($data["photo_url"]);
            $faune->setDescription($data["description"]);
            $manager->persist($faune);
        }

        // ===== 5. Création du contenu de la rubrique Le Cailloux - Flore =====
        $floreData = [
            [
                "name" => "Chêne centenaire",
                "photo_url" => "https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?w=400",
                "description" => "Le chêne est un arbre majestueux pouvant vivre plusieurs centaines d'années. Son bois robuste et ses glands nourrissent de nombreux animaux de la forêt."
            ],
            [
                "name" => "Lavande sauvage",
                "photo_url" => "https://images.unsplash.com/photo-1499002238440-d264edd596ec?w=400",
                "description" => "La lavande sauvage pousse naturellement dans les zones rocailleuses méditerranéennes. Ses fleurs violettes parfumées attirent de nombreux pollinisateurs."
            ],
            [
                "name" => "Coquelicot",
                "photo_url" => "https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=400",
                "description" => "Le coquelicot est une fleur rouge emblématique des champs de céréales. Très résistante, elle fleurit au printemps et en été, égayant les paysages ruraux."
            ],
            [
                "name" => "Marguerite des champs",
                "photo_url" => "https://images.unsplash.com/photo-1463878691443-1671eb2e2abd?w=400",
                "description" => "La marguerite des champs est une fleur blanche à cœur jaune très commune dans les prairies. Elle symbolise l'innocence et la pureté."
            ],
            [
                "name" => "Fougère",
                "photo_url" => "https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=400",
                "description" => "La fougère est une plante sans fleur qui pousse dans les sous-bois humides. Ses frondes vertes et découpées créent un décor luxuriant."
            ]
        ];

        foreach ($floreData as $data) {
            $flore = new Flore();
            $flore->setName($data["name"]);
            $flore->setPhotoUrl($data["photo_url"]);
            $flore->setDescription($data["description"]);
            $manager->persist($flore);
        }

        $manager->flush();
    }
}
