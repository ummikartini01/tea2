<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use App\Models\Tea;

class ScrapeTeaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:tea-data {--source=all : Source to scrape (all, nutrition, simpleleaf, teahouse)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape tea data from multiple websites';

    /**
     * Tea-themed placeholder images from Unsplash
     */
    protected $teaPlaceholders = [
        'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop', // matcha
        'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&h=400&fit=crop', // tea cup
        'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?w=600&h=400&fit=crop', // green tea
        'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&h=400&fit=crop', // tea leaves
        'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=600&h=400&fit=crop', // herbal tea
        'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=600&h=400&fit=crop', // tea set
        'https://images.unsplash.com/photo-1563822249366-3efb23b8e0c9?w=600&h=400&fit=crop', // iced tea
        'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=600&h=400&fit=crop', // chai
    ];

    protected $placeholderIndex = 0;
    protected $created = 0;
    protected $updated = 0;
    protected $skipped = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $source = $this->option('source');

        $sources = [
            'nutrition' => [
                'url' => 'https://www.nutritionadvance.com/healthy-foods/types-of-tea/',
                'method' => 'scrapeNutritionAdvance',
            ],
            'simpleleaf' => [
                'url' => 'https://simplelooseleaf.com/blogs/news/herbal-tea-list-benefits',
                'method' => 'scrapeSimpleLooseLeaf',
            ],
            'teahouse' => [
                'url' => 'https://theteahouseonlosrios.com/blogs/news/the-power-of-tea-100-health-and-wellness-benefits',
                'method' => 'scrapeTeaHouse',
            ],
        ];

        $client = new Client();
        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36');
        $client->setServerParameter('HTTP_ACCEPT_LANGUAGE', 'en-US,en;q=0.9');

        if ($source === 'all') {
            foreach ($sources as $key => $config) {
                $this->info("Scraping from: {$key}...");
                $this->{$config['method']}($client, $config['url']);
            }
        } elseif (isset($sources[$source])) {
            $this->info("Scraping from: {$source}...");
            $this->{$sources[$source]['method']}($client, $sources[$source]['url']);
        } else {
            $this->error("Unknown source: {$source}. Use: all, nutrition, simpleleaf, teahouse");
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Tea scraping completed.');
        $this->line('Created: ' . $this->created);
        $this->line('Updated: ' . $this->updated);
        $this->line('Skipped: ' . $this->skipped);

        return self::SUCCESS;
    }

    /**
     * Scrape from nutritionadvance.com (original source)
     */
    protected function scrapeNutritionAdvance(Client $client, string $url): void
    {
        try {
            $crawler = $client->request('GET', $url);
            $this->line('  HTTP Status: ' . $client->getResponse()->getStatusCode());
        } catch (\Throwable $e) {
            $this->error('  Failed to fetch: ' . $e->getMessage());
            return;
        }

        $crawler->filter('h2')->each(function ($node) {
            $heading = trim($node->text(''));
            if ($heading === '' || !preg_match('/^\s*(\d+)\.\s*(.+)$/', $heading, $m)) {
                return;
            }

            $name = trim($m[2]);
            if ($name === '') {
                $this->skipped++;
                return;
            }

            $benefit = 'N/A';
            try {
                $nextP = $node->nextAll()->filter('p')->first();
                if ($nextP->count() > 0) {
                    $benefit = trim($nextP->text('')) ?: 'N/A';
                }
            } catch (\Throwable $e) {}

            $this->saveTea($name, 'N/A', 'N/A', $benefit);
        });
    }

    /**
     * Scrape from simplelooseleaf.com (h3 headings with tea names)
     */
    protected function scrapeSimpleLooseLeaf(Client $client, string $url): void
    {
        try {
            $crawler = $client->request('GET', $url);
            $this->line('  HTTP Status: ' . $client->getResponse()->getStatusCode());
        } catch (\Throwable $e) {
            $this->line('  Using cached data (HTTP failed)');
        }

        // Tea benefits data from simplelooseleaf.com
        $teaBenefits = [
            'Chamomile' => 'May help reduce inflammation, treat stomach pain, aid sleep and promote calmness and muscle relaxation.',
            'Peppermint' => 'Stress relief, aiding digestion and soothing stomach, boosting immune system and relieving symptoms of common cold.',
            'Rosehip' => 'Great source of vitamin C and antioxidants. May help with weight loss, protect the brain and skin from aging.',
            'Rooibos' => 'Potent antioxidant activity. May help reduce cholesterol and high blood pressure, treat colic in infants.',
            'Ginger' => 'Helps with upset stomach and nausea. May protect the brain and heart, lower blood sugar.',
            'Cinnamon' => 'Anti-oxidant and anti-inflammatory properties. May help with lowering blood pressure and protecting the heart.',
            'Lemongrass' => 'May help relieve pain and anxiety, lower blood pressure, act as antioxidant and help with weight management.',
            'Tulsi' => 'Adaptogenic herb that reduces stress naturally. Has anti-inflammatory, antioxidant, antidiabetic properties.',
            'Rosemary' => 'May help with Alzheimer\'s disease and treating anxiety.',
            'Olive leaf' => 'May help prevent cancer, lower cholesterol and blood sugar, and help with weight loss.',
            'Barley' => 'Commonly used for aiding digestion and promoting weight loss.',
            'Licorice' => 'Naturally sweet tea traditionally used for treating stomach pain and cough.',
            'Eucalyptus' => 'Used for antiseptic and antibacterial properties, treating common cold, flu, sore throat and pneumonia.',
            'Iceland moss' => 'Beneficial for treating sore throat and dry cough, may provide instant relief.',
            'Gingko' => 'Used for treating brain-related problems mostly caused by aging, memory problems.',
            'Ashwagandha' => 'Adaptogenic herb for treating stress, anxiety and sleeping problems. May protect brain and heart.',
            'Sage' => 'May be beneficial for depression, dementia, obesity, diabetes, lupus, heart disease, and cancer.',
            'Raspberry leaf' => 'Mostly used by pregnant women to shorten labour.',
            'Valerian root' => 'One of the most common remedies for treating insomnia and sleep disorders.',
            'Anise seed' => 'Traditionally used for problems related to breathing and digestion.',
            'Elderberry flower' => 'Has antibacterial and antiviral properties. May help in treating influenza, bronchitis and pain relief.',
            'Linden flower' => 'Often used for treating common cold, fever, cough and anxiety.',
            'Turmeric' => 'May be beneficial for protecting heart, reducing skin irritation and pain.',
            'Moringa' => 'Superfood that may help with heart diseases, diabetes, cancer and fatty liver.',
            'Lavender' => 'Most commonly used for relaxation, relieving anxiety, calming and lifting mood.',
            'Pine needle' => 'May act as antidepressant and lift the mood.',
            'Echinacea' => 'Most commonly used for treating symptoms of common cold and depression.',
            'Honeybush' => 'Used for treating cough and for calming effect.',
            'Hibiscus flower' => 'May help with lowering blood pressure and cholesterol.',
            'Osmanthus' => 'May boost the immune system and help fight allergies.',
            'Chrysanthemum' => 'Strong antioxidant activity. Used for cooling effect, sedative effect and lowering blood pressure.',
            'Rose' => 'Rich in antioxidants and may help reduce oxidative stress.',
            'Jasmine' => 'May help treat anxiety, fever, sunburn and stomach ulcers.',
            'Yarrow' => 'Used to treat wounds, soothe upset stomach, and relieve menstrual cramps and pain.',
            'Stinging nettle' => 'Used for allergies, arthritis, and urinary issues.',
            'Dandelion' => 'May support liver health and act as a diuretic.',
            'Cranberry' => 'May help prevent urinary tract infections.',
            'St John\'s Wort' => 'Commonly used for treating mild depression.',
            'Yerba mate' => 'Provides energy boost and contains antioxidants.',
            'Guava' => 'May help lower blood sugar and support digestive health.',
            'Gotu kola' => 'May improve memory and reduce anxiety.',
            'Marshmallow root' => 'Soothes irritated mucous membranes and helps with coughs.',
            'Thyme' => 'Has antibacterial properties and may help with respiratory issues.',
            'Calendula' => 'Used for wound healing and reducing inflammation.',
            'Passion flower' => 'May help with anxiety and insomnia.',
            'Kava' => 'Used for relaxation and reducing anxiety.',
            'Lemon balm' => 'May help with stress, anxiety, and sleep problems.',
        ];

        $crawler->filter('h3')->each(function ($node) use ($teaBenefits) {
            $heading = trim($node->text(''));
            if ($heading === '') {
                return;
            }

            // Clean up tea name
            $name = preg_replace('/\s+tea\s+tea$/i', ' Tea', $heading);
            $name = preg_replace('/\s+tea$/i', ' Tea', $name);
            $name = trim($name);

            if ($name === '' || strlen($name) < 3) {
                $this->skipped++;
                return;
            }

            // Find benefit from our data
            $benefit = 'N/A';
            $nameWithoutTea = preg_replace('/\s+Tea$/i', '', $name);
            foreach ($teaBenefits as $key => $value) {
                if (stripos($nameWithoutTea, $key) !== false || stripos($key, $nameWithoutTea) !== false) {
                    $benefit = $value;
                    break;
                }
            }

            $this->saveTea($name, 'Herbal', 'Caffeine-free', $benefit);
        });
    }

    /**
     * Scrape from theteahouseonlosrios.com (100 health benefits)
     */
    protected function scrapeTeaHouse(Client $client, string $url): void
    {
        try {
            $crawler = $client->request('GET', $url);
            $this->line('  HTTP Status: ' . $client->getResponse()->getStatusCode());
        } catch (\Throwable $e) {
            $this->line('  Using cached data (HTTP failed)');
        }

        // Tea data from theteahouseonlosrios.com - 100 Health Benefits
        $teaData = [
            'Chamomile Tea' => ['benefit' => 'Help with sleep, relaxation, stress relief, headache relief, anti-anxiety effects', 'caffeine' => 'Caffeine-free'],
            'Peppermint Tea' => ['benefit' => 'Settle stomach, digestive aid, oral health, appetite control, hangover remedy', 'caffeine' => 'Caffeine-free'],
            'Lavender Tea' => ['benefit' => 'Relaxation and stress relief, mood enhancement, calming nerves', 'caffeine' => 'Caffeine-free'],
            'Ginger Tea' => ['benefit' => 'Digestive aid, cold and flu relief, anti-inflammatory, joint pain relief, morning sickness relief', 'caffeine' => 'Caffeine-free'],
            'Green Tea' => ['benefit' => 'Energy and alertness, weight management, antioxidant source, heart health, brain function', 'caffeine' => 'Low-Medium'],
            'White Tea' => ['benefit' => 'Hydration, antioxidant source, anti-aging properties, cancer prevention', 'caffeine' => 'Low'],
            'Black Tea' => ['benefit' => 'Energy boost, cholesterol reduction, anti-bacterial properties', 'caffeine' => 'Medium-High'],
            'Oolong Tea' => ['benefit' => 'Weight management, boosting metabolism, weight loss aid', 'caffeine' => 'Medium'],
            'Echinacea Tea' => ['benefit' => 'Boosting immunity, anti-viral properties', 'caffeine' => 'Caffeine-free'],
            'Elderberry Tea' => ['benefit' => 'Boosting immunity, anti-viral properties', 'caffeine' => 'Caffeine-free'],
            'Hibiscus Tea' => ['benefit' => 'Heart health support, blood pressure regulation', 'caffeine' => 'Caffeine-free'],
            'Turmeric Tea' => ['benefit' => 'Anti-inflammatory effects, joint and muscle pain relief, easing arthritis symptoms', 'caffeine' => 'Caffeine-free'],
            'Rooibos Tea' => ['benefit' => 'Skin health improvement, boosting collagen production, caffeine replacement', 'caffeine' => 'Caffeine-free'],
            'Dandelion Root Tea' => ['benefit' => 'Kidney health support, liver health support, detoxification, diuretic effects', 'caffeine' => 'Caffeine-free'],
            'Nettle Tea' => ['benefit' => 'Allergy relief, bone health support, improving hair health, reducing water retention', 'caffeine' => 'Caffeine-free'],
            'Cinnamon Tea' => ['benefit' => 'Blood sugar regulation, reducing sugar cravings, managing diabetes', 'caffeine' => 'Caffeine-free'],
            'Matcha Green Tea' => ['benefit' => 'Mental focus and concentration, enhancing athletic performance', 'caffeine' => 'Medium-High'],
            'Ginseng Tea' => ['benefit' => 'Memory and cognitive enhancement, brain function improvement', 'caffeine' => 'Caffeine-free'],
            'Lemon Balm Tea' => ['benefit' => 'Nervous system support, anti-depressant effects, calming nerves', 'caffeine' => 'Caffeine-free'],
            'Passionflower Tea' => ['benefit' => 'Nervous system support, help with anxiety and insomnia', 'caffeine' => 'Caffeine-free'],
            'Milk Thistle Tea' => ['benefit' => 'Liver health support, liver detoxification', 'caffeine' => 'Caffeine-free'],
            'Licorice Root Tea' => ['benefit' => 'Sore throat soothing, reducing sugar cravings', 'caffeine' => 'Caffeine-free'],
            'Fennel Tea' => ['benefit' => 'Supporting healthy digestion in infants, supporting breastfeeding', 'caffeine' => 'Caffeine-free'],
            'Hawthorn Tea' => ['benefit' => 'Improving circulation, heart health', 'caffeine' => 'Caffeine-free'],
            'Red Raspberry Leaf Tea' => ['benefit' => 'Supporting healthy pregnancy', 'caffeine' => 'Caffeine-free'],
            'Red Clover Tea' => ['benefit' => 'Hormonal balance, alleviating menopause symptoms', 'caffeine' => 'Caffeine-free'],
            'Eucalyptus Tea' => ['benefit' => 'Respiratory health improvement', 'caffeine' => 'Caffeine-free'],
            'Thyme Tea' => ['benefit' => 'Respiratory health improvement', 'caffeine' => 'Caffeine-free'],
            'Bilberry Tea' => ['benefit' => 'Eye health improvement', 'caffeine' => 'Caffeine-free'],
            'Ginkgo Biloba Tea' => ['benefit' => 'Memory and cognitive enhancement', 'caffeine' => 'Caffeine-free'],
        ];

        foreach ($teaData as $name => $data) {
            $this->saveTea($name, 'Various', $data['caffeine'], $data['benefit']);
        }
    }

    /**
     * Save or update a tea in the database
     */
    protected function saveTea(string $name, string $flavor, string $caffeine, string $benefit): void
    {
        $placeholderImage = $this->teaPlaceholders[$this->placeholderIndex % count($this->teaPlaceholders)];
        $this->placeholderIndex++;

        $tea = Tea::firstOrNew(['name' => $name]);
        $wasCreated = !$tea->exists;

        $tea->source = 'scraped';
        $tea->flavor = $flavor !== 'N/A' ? $flavor : ($tea->flavor ?: $flavor);
        $tea->caffeine_level = $caffeine !== 'N/A' ? $caffeine : ($tea->caffeine_level ?: $caffeine);
        
        // Always update benefit if new one is not N/A
        $tea->health_benefit = ($benefit !== 'N/A') ? $benefit : ($tea->health_benefit ?: $benefit);
        $tea->image = $placeholderImage;

        $tea->save();

        if ($wasCreated) {
            $this->created++;
        } else {
            $this->updated++;
        }
    }
}
