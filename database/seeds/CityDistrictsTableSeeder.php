<?php

use Illuminate\Database\Seeder;

class CityDistrictsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('city_districts')->delete();
        
        \DB::table('city_districts')->insert(array (
            0 => 
            array (
                'id' => 5,
                'name' => 'район Арбат',
                'slug' => 'rayon-arbat',
                'city_id' => 1,
            ),
            1 => 
            array (
                'id' => 6,
                'name' => 'Басманный район',
                'slug' => 'basmannyy-rayon',
                'city_id' => 1,
            ),
            2 => 
            array (
                'id' => 7,
                'name' => 'район Замоскворечье',
                'slug' => 'rayon-zamoskvoreche',
                'city_id' => 1,
            ),
            3 => 
            array (
                'id' => 8,
                'name' => 'Красносельский район',
                'slug' => 'krasnoselskiy-rayon',
                'city_id' => 1,
            ),
            4 => 
            array (
                'id' => 9,
                'name' => 'Мещанский район',
                'slug' => 'meshchanskiy-rayon',
                'city_id' => 1,
            ),
            5 => 
            array (
                'id' => 10,
                'name' => 'Пресненский район',
                'slug' => 'presnenskiy-rayon',
                'city_id' => 1,
            ),
            6 => 
            array (
                'id' => 11,
                'name' => 'Таганский район',
                'slug' => 'taganskiy-rayon',
                'city_id' => 1,
            ),
            7 => 
            array (
                'id' => 12,
                'name' => 'Тверской район',
                'slug' => 'tverskoy-rayon',
                'city_id' => 1,
            ),
            8 => 
            array (
                'id' => 13,
                'name' => 'район Хамовники',
                'slug' => 'rayon-hamovniki',
                'city_id' => 1,
            ),
            9 => 
            array (
                'id' => 14,
                'name' => 'район Якиманка',
                'slug' => 'rayon-yakimanka',
                'city_id' => 1,
            ),
            10 => 
            array (
                'id' => 15,
                'name' => 'район Аэропорт',
                'slug' => 'rayon-aeroport',
                'city_id' => 1,
            ),
            11 => 
            array (
                'id' => 16,
                'name' => 'Беговой район',
                'slug' => 'begovoy-rayon',
                'city_id' => 1,
            ),
            12 => 
            array (
                'id' => 17,
                'name' => 'Бескудниковский район',
                'slug' => 'beskudnikovskiy-rayon',
                'city_id' => 1,
            ),
            13 => 
            array (
                'id' => 18,
                'name' => 'Войковский район',
                'slug' => 'voykovskiy-rayon',
                'city_id' => 1,
            ),
            14 => 
            array (
                'id' => 19,
                'name' => 'район Восточное Дегунино',
                'slug' => 'rayon-vostochnoe-degunino',
                'city_id' => 1,
            ),
            15 => 
            array (
                'id' => 20,
                'name' => 'Головинский район',
                'slug' => 'golovinskiy-rayon',
                'city_id' => 1,
            ),
            16 => 
            array (
                'id' => 21,
                'name' => 'Дмитровский район',
                'slug' => 'dmitrovskiy-rayon',
                'city_id' => 1,
            ),
            17 => 
            array (
                'id' => 22,
                'name' => 'район Западное Дегунино',
                'slug' => 'rayon-zapadnoe-degunino',
                'city_id' => 1,
            ),
            18 => 
            array (
                'id' => 23,
                'name' => 'район Коптево',
                'slug' => 'rayon-koptevo',
                'city_id' => 1,
            ),
            19 => 
            array (
                'id' => 24,
                'name' => 'Левобережный район',
                'slug' => 'levoberezhnyy-rayon',
                'city_id' => 1,
            ),
            20 => 
            array (
                'id' => 25,
                'name' => 'Молжаниновский район',
                'slug' => 'molzhaninovskiy-rayon',
                'city_id' => 1,
            ),
            21 => 
            array (
                'id' => 26,
                'name' => 'Савёловский район',
                'slug' => 'savelovskiy-rayon',
                'city_id' => 1,
            ),
            22 => 
            array (
                'id' => 27,
                'name' => 'район Сокол',
                'slug' => 'rayon-sokol',
                'city_id' => 1,
            ),
            23 => 
            array (
                'id' => 28,
                'name' => 'Тимирязевский район',
                'slug' => 'timiryazevskiy-rayon',
                'city_id' => 1,
            ),
            24 => 
            array (
                'id' => 29,
                'name' => 'район Ховрино',
                'slug' => 'rayon-hovrino',
                'city_id' => 1,
            ),
            25 => 
            array (
                'id' => 30,
                'name' => 'Хорошёвский район',
                'slug' => 'horoshevskiy-rayon',
                'city_id' => 1,
            ),
            26 => 
            array (
                'id' => 31,
                'name' => 'Алексеевский район',
                'slug' => 'alekseevskiy-rayon',
                'city_id' => 1,
            ),
            27 => 
            array (
                'id' => 32,
                'name' => 'Алтуфьевский район',
                'slug' => 'altufevskiy-rayon',
                'city_id' => 1,
            ),
            28 => 
            array (
                'id' => 33,
                'name' => 'Бабушкинский район',
                'slug' => 'babushkinskiy-rayon',
                'city_id' => 1,
            ),
            29 => 
            array (
                'id' => 34,
                'name' => 'район Бибирево',
                'slug' => 'rayon-bibirevo',
                'city_id' => 1,
            ),
            30 => 
            array (
                'id' => 35,
                'name' => 'Бутырский район',
                'slug' => 'butyrskiy-rayon',
                'city_id' => 1,
            ),
            31 => 
            array (
                'id' => 36,
                'name' => 'район Лианозово',
                'slug' => 'rayon-lianozovo',
                'city_id' => 1,
            ),
            32 => 
            array (
                'id' => 37,
                'name' => 'Лосиноостровский район',
                'slug' => 'losinoostrovskiy-rayon',
                'city_id' => 1,
            ),
            33 => 
            array (
                'id' => 38,
                'name' => 'район Марфино',
                'slug' => 'rayon-marfino',
                'city_id' => 1,
            ),
            34 => 
            array (
                'id' => 39,
                'name' => 'район Марьина Роща',
                'slug' => 'rayon-marina-roshcha',
                'city_id' => 1,
            ),
            35 => 
            array (
                'id' => 40,
                'name' => 'Останкинский район',
                'slug' => 'ostankinskiy-rayon',
                'city_id' => 1,
            ),
            36 => 
            array (
                'id' => 41,
                'name' => 'район Отрадное',
                'slug' => 'rayon-otradnoe',
                'city_id' => 1,
            ),
            37 => 
            array (
                'id' => 42,
                'name' => 'район Ростокино',
                'slug' => 'rayon-rostokino',
                'city_id' => 1,
            ),
            38 => 
            array (
                'id' => 43,
                'name' => 'район Свиблово',
                'slug' => 'rayon-sviblovo',
                'city_id' => 1,
            ),
            39 => 
            array (
                'id' => 44,
                'name' => 'Северный район',
                'slug' => 'severnyy-rayon',
                'city_id' => 1,
            ),
            40 => 
            array (
                'id' => 45,
                'name' => 'район Северное Медведково',
                'slug' => 'rayon-severnoe-medvedkovo',
                'city_id' => 1,
            ),
            41 => 
            array (
                'id' => 46,
                'name' => 'район Южное Медведково',
                'slug' => 'rayon-yuzhnoe-medvedkovo',
                'city_id' => 1,
            ),
            42 => 
            array (
                'id' => 47,
                'name' => 'Ярославский район',
                'slug' => 'yaroslavskiy-rayon',
                'city_id' => 1,
            ),
            43 => 
            array (
                'id' => 48,
                'name' => 'район Богородское',
                'slug' => 'rayon-bogorodskoe',
                'city_id' => 1,
            ),
            44 => 
            array (
                'id' => 49,
                'name' => 'район Вешняки',
                'slug' => 'rayon-veshnyaki',
                'city_id' => 1,
            ),
            45 => 
            array (
                'id' => 50,
                'name' => 'Восточный район',
                'slug' => 'vostochnyy-rayon',
                'city_id' => 1,
            ),
            46 => 
            array (
                'id' => 51,
                'name' => 'район Восточное Измайлово',
                'slug' => 'rayon-vostochnoe-izmaylovo',
                'city_id' => 1,
            ),
            47 => 
            array (
                'id' => 52,
                'name' => 'район Гольяново',
                'slug' => 'rayon-golyanovo',
                'city_id' => 1,
            ),
            48 => 
            array (
                'id' => 53,
                'name' => 'район Ивановское',
                'slug' => 'rayon-ivanovskoe',
                'city_id' => 1,
            ),
            49 => 
            array (
                'id' => 54,
                'name' => 'район Измайлово',
                'slug' => 'rayon-izmaylovo',
                'city_id' => 1,
            ),
            50 => 
            array (
                'id' => 55,
                'name' => 'Косино-Ухтомский район',
                'slug' => 'kosino-uhtomskiy-rayon',
                'city_id' => 1,
            ),
            51 => 
            array (
                'id' => 56,
                'name' => 'район Метрогородок',
                'slug' => 'rayon-metrogorodok',
                'city_id' => 1,
            ),
            52 => 
            array (
                'id' => 57,
                'name' => 'район Новогиреево',
                'slug' => 'rayon-novogireevo',
                'city_id' => 1,
            ),
            53 => 
            array (
                'id' => 58,
                'name' => 'район Новокосино',
                'slug' => 'rayon-novokosino',
                'city_id' => 1,
            ),
            54 => 
            array (
                'id' => 59,
                'name' => 'район Перово',
                'slug' => 'rayon-perovo',
                'city_id' => 1,
            ),
            55 => 
            array (
                'id' => 60,
                'name' => 'район Преображенское',
                'slug' => 'rayon-preobrazhenskoe',
                'city_id' => 1,
            ),
            56 => 
            array (
                'id' => 61,
                'name' => 'район Северное Измайлово',
                'slug' => 'rayon-severnoe-izmaylovo',
                'city_id' => 1,
            ),
            57 => 
            array (
                'id' => 62,
                'name' => 'район Соколиная Гора',
                'slug' => 'rayon-sokolinaya-gora',
                'city_id' => 1,
            ),
            58 => 
            array (
                'id' => 63,
                'name' => 'район Сокольники',
                'slug' => 'rayon-sokolniki',
                'city_id' => 1,
            ),
            59 => 
            array (
                'id' => 64,
                'name' => 'район Выхино-Жулебино',
                'slug' => 'rayon-vyhino-zhulebino',
                'city_id' => 1,
            ),
            60 => 
            array (
                'id' => 65,
                'name' => 'район Капотня',
                'slug' => 'rayon-kapotnya',
                'city_id' => 1,
            ),
            61 => 
            array (
                'id' => 66,
                'name' => 'район Кузьминки',
                'slug' => 'rayon-kuzminki',
                'city_id' => 1,
            ),
            62 => 
            array (
                'id' => 67,
                'name' => 'район Лефортово',
                'slug' => 'rayon-lefortovo',
                'city_id' => 1,
            ),
            63 => 
            array (
                'id' => 68,
                'name' => 'район Люблино',
                'slug' => 'rayon-lyublino',
                'city_id' => 1,
            ),
            64 => 
            array (
                'id' => 69,
                'name' => 'район Марьино',
                'slug' => 'rayon-marino',
                'city_id' => 1,
            ),
            65 => 
            array (
                'id' => 70,
                'name' => 'район Некрасовка',
                'slug' => 'rayon-nekrasovka',
                'city_id' => 1,
            ),
            66 => 
            array (
                'id' => 71,
                'name' => 'Нижегородский район',
                'slug' => 'nizhegorodskiy-rayon',
                'city_id' => 1,
            ),
            67 => 
            array (
                'id' => 72,
                'name' => 'район Печатники',
                'slug' => 'rayon-pechatniki',
                'city_id' => 1,
            ),
            68 => 
            array (
                'id' => 73,
                'name' => 'Рязанский район',
                'slug' => 'ryazanskiy-rayon',
                'city_id' => 1,
            ),
            69 => 
            array (
                'id' => 74,
                'name' => 'район Текстильщики',
                'slug' => 'rayon-tekstilshchiki',
                'city_id' => 1,
            ),
            70 => 
            array (
                'id' => 75,
                'name' => 'Южнопортовый район',
                'slug' => 'yuzhnoportovyy-rayon',
                'city_id' => 1,
            ),
            71 => 
            array (
                'id' => 76,
                'name' => 'район Бирюлёво Восточное',
                'slug' => 'rayon-biryulevo-vostochnoe',
                'city_id' => 1,
            ),
            72 => 
            array (
                'id' => 77,
                'name' => 'район Бирюлёво Западное',
                'slug' => 'rayon-biryulevo-zapadnoe',
                'city_id' => 1,
            ),
            73 => 
            array (
                'id' => 78,
                'name' => 'район Братеево',
                'slug' => 'rayon-brateevo',
                'city_id' => 1,
            ),
            74 => 
            array (
                'id' => 79,
                'name' => 'Даниловский район',
                'slug' => 'danilovskiy-rayon',
                'city_id' => 1,
            ),
            75 => 
            array (
                'id' => 80,
                'name' => 'Донской район',
                'slug' => 'donskoy-rayon',
                'city_id' => 1,
            ),
            76 => 
            array (
                'id' => 81,
                'name' => 'район Зябликово',
                'slug' => 'rayon-zyablikovo',
                'city_id' => 1,
            ),
            77 => 
            array (
                'id' => 82,
                'name' => 'район Москворечье-Сабурово',
                'slug' => 'rayon-moskvoreche-saburovo',
                'city_id' => 1,
            ),
            78 => 
            array (
                'id' => 83,
                'name' => 'район Нагатино-Садовники',
                'slug' => 'rayon-nagatino-sadovniki',
                'city_id' => 1,
            ),
            79 => 
            array (
                'id' => 84,
                'name' => 'район Нагатинский Затон',
                'slug' => 'rayon-nagatinskiy-zaton',
                'city_id' => 1,
            ),
            80 => 
            array (
                'id' => 85,
                'name' => 'Нагорный район',
                'slug' => 'nagornyy-rayon',
                'city_id' => 1,
            ),
            81 => 
            array (
                'id' => 86,
                'name' => 'район Орехово-Борисово Северное',
                'slug' => 'rayon-orehovo-borisovo-severnoe',
                'city_id' => 1,
            ),
            82 => 
            array (
                'id' => 87,
                'name' => 'район Орехово-Борисово Южное',
                'slug' => 'rayon-orehovo-borisovo-yuzhnoe',
                'city_id' => 1,
            ),
            83 => 
            array (
                'id' => 88,
                'name' => 'район Царицыно',
                'slug' => 'rayon-caricyno',
                'city_id' => 1,
            ),
            84 => 
            array (
                'id' => 89,
                'name' => 'район Чертаново Северное',
                'slug' => 'rayon-chertanovo-severnoe',
                'city_id' => 1,
            ),
            85 => 
            array (
                'id' => 90,
                'name' => 'район Чертаново Центральное',
                'slug' => 'rayon-chertanovo-centralnoe',
                'city_id' => 1,
            ),
            86 => 
            array (
                'id' => 91,
                'name' => 'район Чертаново Южное',
                'slug' => 'rayon-chertanovo-yuzhnoe',
                'city_id' => 1,
            ),
            87 => 
            array (
                'id' => 92,
                'name' => 'Академический район',
                'slug' => 'akademicheskiy-rayon',
                'city_id' => 1,
            ),
            88 => 
            array (
                'id' => 93,
                'name' => 'Гагаринский район',
                'slug' => 'gagarinskiy-rayon',
                'city_id' => 1,
            ),
            89 => 
            array (
                'id' => 94,
                'name' => 'район Зюзино',
                'slug' => 'rayon-zyuzino',
                'city_id' => 1,
            ),
            90 => 
            array (
                'id' => 95,
                'name' => 'район Коньково',
                'slug' => 'rayon-konkovo',
                'city_id' => 1,
            ),
            91 => 
            array (
                'id' => 96,
                'name' => 'район Котловка',
                'slug' => 'rayon-kotlovka',
                'city_id' => 1,
            ),
            92 => 
            array (
                'id' => 97,
                'name' => 'Ломоносовский район',
                'slug' => 'lomonosovskiy-rayon',
                'city_id' => 1,
            ),
            93 => 
            array (
                'id' => 98,
                'name' => 'Обручевский район',
                'slug' => 'obruchevskiy-rayon',
                'city_id' => 1,
            ),
            94 => 
            array (
                'id' => 99,
                'name' => 'район Северное Бутово',
                'slug' => 'rayon-severnoe-butovo',
                'city_id' => 1,
            ),
            95 => 
            array (
                'id' => 100,
                'name' => 'район Тёплый Стан',
                'slug' => 'rayon-teplyy-stan',
                'city_id' => 1,
            ),
            96 => 
            array (
                'id' => 101,
                'name' => 'район Черёмушки',
                'slug' => 'rayon-cheremushki',
                'city_id' => 1,
            ),
            97 => 
            array (
                'id' => 102,
                'name' => 'район Южное Бутово',
                'slug' => 'rayon-yuzhnoe-butovo',
                'city_id' => 1,
            ),
            98 => 
            array (
                'id' => 103,
                'name' => 'район Ясенево',
                'slug' => 'rayon-yasenevo',
                'city_id' => 1,
            ),
            99 => 
            array (
                'id' => 104,
                'name' => 'район Дорогомилово',
                'slug' => 'rayon-dorogomilovo',
                'city_id' => 1,
            ),
            100 => 
            array (
                'id' => 105,
                'name' => 'район Крылатское',
                'slug' => 'rayon-krylatskoe',
                'city_id' => 1,
            ),
            101 => 
            array (
                'id' => 106,
                'name' => 'район Кунцево',
                'slug' => 'rayon-kuncevo',
                'city_id' => 1,
            ),
            102 => 
            array (
                'id' => 107,
                'name' => 'Можайский район',
                'slug' => 'mozhayskiy-rayon',
                'city_id' => 1,
            ),
            103 => 
            array (
                'id' => 108,
                'name' => 'район Ново-Переделкино',
                'slug' => 'rayon-novo-peredelkino',
                'city_id' => 1,
            ),
            104 => 
            array (
                'id' => 109,
                'name' => 'район Очаково-Матвеевское',
                'slug' => 'rayon-ochakovo-matveevskoe',
                'city_id' => 1,
            ),
            105 => 
            array (
                'id' => 110,
                'name' => 'район Проспект Вернадского',
                'slug' => 'rayon-prospekt-vernadskogo',
                'city_id' => 1,
            ),
            106 => 
            array (
                'id' => 111,
                'name' => 'район Раменки',
                'slug' => 'rayon-ramenki',
                'city_id' => 1,
            ),
            107 => 
            array (
                'id' => 112,
                'name' => 'район Солнцево',
                'slug' => 'rayon-solncevo',
                'city_id' => 1,
            ),
            108 => 
            array (
                'id' => 113,
                'name' => 'район Тропарёво-Никулино',
                'slug' => 'rayon-troparevo-nikulino',
                'city_id' => 1,
            ),
            109 => 
            array (
                'id' => 114,
                'name' => 'район Филёвский Парк',
                'slug' => 'rayon-filevskiy-park',
                'city_id' => 1,
            ),
            110 => 
            array (
                'id' => 115,
                'name' => 'район Фили-Давыдково',
                'slug' => 'rayon-fili-davydkovo',
                'city_id' => 1,
            ),
            111 => 
            array (
                'id' => 116,
                'name' => 'район Куркино',
                'slug' => 'rayon-kurkino',
                'city_id' => 1,
            ),
            112 => 
            array (
                'id' => 117,
                'name' => 'район Митино',
                'slug' => 'rayon-mitino',
                'city_id' => 1,
            ),
            113 => 
            array (
                'id' => 118,
                'name' => 'район Покровское-Стрешнево',
                'slug' => 'rayon-pokrovskoe-streshnevo',
                'city_id' => 1,
            ),
            114 => 
            array (
                'id' => 119,
                'name' => 'район Северное Тушино',
                'slug' => 'rayon-severnoe-tushino',
                'city_id' => 1,
            ),
            115 => 
            array (
                'id' => 120,
                'name' => 'район Хорошёво-Мнёвники',
                'slug' => 'rayon-horoshevo-mnevniki',
                'city_id' => 1,
            ),
            116 => 
            array (
                'id' => 121,
                'name' => 'район Щукино',
                'slug' => 'rayon-shchukino',
                'city_id' => 1,
            ),
            117 => 
            array (
                'id' => 122,
                'name' => 'район Южное Тушино',
                'slug' => 'rayon-yuzhnoe-tushino',
                'city_id' => 1,
            ),
            118 => 
            array (
                'id' => 123,
                'name' => 'район Строгино',
                'slug' => 'rayon-strogino',
                'city_id' => 1,
            ),
            119 => 
            array (
                'id' => 124,
                'name' => 'район СП Внуковское',
                'slug' => 'rayon-sp-vnukovskoe',
                'city_id' => 1,
            ),
            120 => 
            array (
                'id' => 125,
                'name' => 'район СП Воскресенское',
                'slug' => 'rayon-sp-voskresenskoe',
                'city_id' => 1,
            ),
            121 => 
            array (
                'id' => 126,
                'name' => 'район СП Десёновское',
                'slug' => 'rayon-sp-desenovskoe',
                'city_id' => 1,
            ),
            122 => 
            array (
                'id' => 127,
                'name' => 'район СП Кокошкино',
                'slug' => 'rayon-sp-kokoshkino',
                'city_id' => 1,
            ),
            123 => 
            array (
                'id' => 128,
                'name' => 'район СП Марушкинское',
                'slug' => 'rayon-sp-marushkinskoe',
                'city_id' => 1,
            ),
            124 => 
            array (
                'id' => 129,
                'name' => 'район СП Московский',
                'slug' => 'rayon-sp-moskovskiy',
                'city_id' => 1,
            ),
            125 => 
            array (
                'id' => 130,
                'name' => 'район СП Мосрентген',
                'slug' => 'rayon-sp-mosrentgen',
                'city_id' => 1,
            ),
            126 => 
            array (
                'id' => 131,
                'name' => 'район СП Рязановское',
                'slug' => 'rayon-sp-ryazanovskoe',
                'city_id' => 1,
            ),
            127 => 
            array (
                'id' => 132,
                'name' => 'район СП Сосенское',
                'slug' => 'rayon-sp-sosenskoe',
                'city_id' => 1,
            ),
            128 => 
            array (
                'id' => 133,
                'name' => 'район СП Филимонковское',
                'slug' => 'rayon-sp-filimonkovskoe',
                'city_id' => 1,
            ),
            129 => 
            array (
                'id' => 134,
                'name' => 'район ГО Щербинка',
                'slug' => 'rayon-go-shcherbinka',
                'city_id' => 1,
            ),
            130 => 
            array (
                'id' => 135,
                'name' => 'район СП Вороновское',
                'slug' => 'rayon-sp-voronovskoe',
                'city_id' => 1,
            ),
            131 => 
            array (
                'id' => 136,
                'name' => 'район СП Киевский',
                'slug' => 'rayon-sp-kievskiy',
                'city_id' => 1,
            ),
            132 => 
            array (
                'id' => 137,
                'name' => 'район СП Клёновское',
                'slug' => 'rayon-sp-klenovskoe',
                'city_id' => 1,
            ),
            133 => 
            array (
                'id' => 138,
                'name' => 'район СП Краснопахорское',
                'slug' => 'rayon-sp-krasnopahorskoe',
                'city_id' => 1,
            ),
            134 => 
            array (
                'id' => 139,
                'name' => 'район СП Михайлово-Ярцевское',
                'slug' => 'rayon-sp-mihaylovo-yarcevskoe',
                'city_id' => 1,
            ),
            135 => 
            array (
                'id' => 140,
                'name' => 'район СП Новофёдоровское',
                'slug' => 'rayon-sp-novofedorovskoe',
                'city_id' => 1,
            ),
            136 => 
            array (
                'id' => 141,
                'name' => 'район СП Первомайское',
                'slug' => 'rayon-sp-pervomayskoe',
                'city_id' => 1,
            ),
            137 => 
            array (
                'id' => 142,
                'name' => 'район СП Роговское',
                'slug' => 'rayon-sp-rogovskoe',
                'city_id' => 1,
            ),
            138 => 
            array (
                'id' => 143,
                'name' => 'район ГО Троицк',
                'slug' => 'rayon-go-troick',
                'city_id' => 1,
            ),
            139 => 
            array (
                'id' => 144,
                'name' => 'район СП Щаповское',
                'slug' => 'rayon-sp-shchapovskoe',
                'city_id' => 1,
            ),
            140 => 
            array (
                'id' => 145,
                'name' => 'Адмиралтейский район',
                'slug' => 'admiralteyskiy-rayon',
                'city_id' => 3,
            ),
            141 => 
            array (
                'id' => 146,
                'name' => 'Василеостровский район',
                'slug' => 'vasileostrovskiy-rayon',
                'city_id' => 3,
            ),
            142 => 
            array (
                'id' => 147,
                'name' => 'Выборгский район',
                'slug' => 'vyborgskiy-rayon',
                'city_id' => 3,
            ),
            143 => 
            array (
                'id' => 148,
                'name' => 'Калининский район',
                'slug' => 'kalininskiy-rayon',
                'city_id' => 3,
            ),
            144 => 
            array (
                'id' => 149,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon',
                'city_id' => 3,
            ),
            145 => 
            array (
                'id' => 150,
                'name' => 'Колпинский район',
                'slug' => 'kolpinskiy-rayon',
                'city_id' => 3,
            ),
            146 => 
            array (
                'id' => 151,
                'name' => 'Красногвардейский район',
                'slug' => 'krasnogvardeyskiy-rayon',
                'city_id' => 3,
            ),
            147 => 
            array (
                'id' => 152,
                'name' => 'Красносельский район',
                'slug' => 'krasnoselskiy-rayon-1',
                'city_id' => 3,
            ),
            148 => 
            array (
                'id' => 153,
                'name' => 'Кронштадтский район',
                'slug' => 'kronshtadtskiy-rayon',
                'city_id' => 3,
            ),
            149 => 
            array (
                'id' => 154,
                'name' => 'Курортный район',
                'slug' => 'kurortnyy-rayon',
                'city_id' => 3,
            ),
            150 => 
            array (
                'id' => 155,
                'name' => 'Московский район',
                'slug' => 'moskovskiy-rayon',
                'city_id' => 3,
            ),
            151 => 
            array (
                'id' => 156,
                'name' => 'Невский район',
                'slug' => 'nevskiy-rayon',
                'city_id' => 3,
            ),
            152 => 
            array (
                'id' => 157,
                'name' => 'Петроградский район',
                'slug' => 'petrogradskiy-rayon',
                'city_id' => 3,
            ),
            153 => 
            array (
                'id' => 158,
                'name' => 'Петродворцовый район',
                'slug' => 'petrodvorcovyy-rayon',
                'city_id' => 3,
            ),
            154 => 
            array (
                'id' => 159,
                'name' => 'Приморский район',
                'slug' => 'primorskiy-rayon',
                'city_id' => 3,
            ),
            155 => 
            array (
                'id' => 160,
                'name' => 'Пушкинский район',
                'slug' => 'pushkinskiy-rayon',
                'city_id' => 3,
            ),
            156 => 
            array (
                'id' => 161,
                'name' => 'Фрунзенский район',
                'slug' => 'frunzenskiy-rayon',
                'city_id' => 3,
            ),
            157 => 
            array (
                'id' => 162,
                'name' => 'Центральный район',
                'slug' => 'centralnyy-rayon',
                'city_id' => 3,
            ),
            158 => 
            array (
                'id' => 163,
                'name' => 'Ленсоветовский район',
                'slug' => 'lensovetovskiy-rayon',
                'city_id' => 3,
            ),
            159 => 
            array (
                'id' => 164,
                'name' => 'Фрунзенский район',
                'slug' => 'frunzenskiy-rayon-1',
                'city_id' => 4,
            ),
            160 => 
            array (
                'id' => 165,
                'name' => 'Советский район',
                'slug' => 'sovetskiy-rayon',
                'city_id' => 4,
            ),
            161 => 
            array (
                'id' => 166,
                'name' => 'Первореченский район',
                'slug' => 'pervorechenskiy-rayon',
                'city_id' => 4,
            ),
            162 => 
            array (
                'id' => 167,
                'name' => 'Первомайский район',
                'slug' => 'pervomayskiy-rayon',
                'city_id' => 4,
            ),
            163 => 
            array (
                'id' => 168,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon',
                'city_id' => 4,
            ),
            164 => 
            array (
                'id' => 169,
                'name' => 'Центральный район',
                'slug' => 'centralnyy-rayon-1',
                'city_id' => 5,
            ),
            165 => 
            array (
                'id' => 170,
                'name' => 'Тракторозаводский район',
                'slug' => 'traktorozavodskiy-rayon',
                'city_id' => 5,
            ),
            166 => 
            array (
                'id' => 171,
                'name' => 'Советский район',
                'slug' => 'sovetskiy-rayon-1',
                'city_id' => 5,
            ),
            167 => 
            array (
                'id' => 172,
                'name' => 'Краснооктябрьский район',
                'slug' => 'krasnooktyabrskiy-rayon',
                'city_id' => 5,
            ),
            168 => 
            array (
                'id' => 173,
                'name' => 'Красноармейский район',
                'slug' => 'krasnoarmeyskiy-rayon',
                'city_id' => 5,
            ),
            169 => 
            array (
                'id' => 174,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-1',
                'city_id' => 5,
            ),
            170 => 
            array (
                'id' => 175,
                'name' => 'Дзержинский район',
                'slug' => 'dzerzhinskiy-rayon',
                'city_id' => 5,
            ),
            171 => 
            array (
                'id' => 176,
                'name' => 'Ворошиловский район',
                'slug' => 'voroshilovskiy-rayon',
                'city_id' => 5,
            ),
            172 => 
            array (
                'id' => 177,
                'name' => 'Центральный район',
                'slug' => 'centralnyy-rayon-2',
                'city_id' => 6,
            ),
            173 => 
            array (
                'id' => 178,
                'name' => 'Советский район',
                'slug' => 'sovetskiy-rayon-2',
                'city_id' => 6,
            ),
            174 => 
            array (
                'id' => 179,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon-1',
                'city_id' => 6,
            ),
            175 => 
            array (
                'id' => 180,
                'name' => 'Левобережный район',
                'slug' => 'levoberezhnyy-rayon-1',
                'city_id' => 6,
            ),
            176 => 
            array (
                'id' => 181,
                'name' => 'Коминтерновский район',
                'slug' => 'kominternovskiy-rayon',
                'city_id' => 6,
            ),
            177 => 
            array (
                'id' => 182,
                'name' => 'Железнодорожный район',
                'slug' => 'zheleznodorozhnyy-rayon',
                'city_id' => 6,
            ),
            178 => 
            array (
                'id' => 183,
                'name' => 'Чкаловский район',
                'slug' => 'chkalovskiy-rayon',
                'city_id' => 7,
            ),
            179 => 
            array (
                'id' => 184,
                'name' => 'Орджоникидзевский район',
                'slug' => 'ordzhonikidzevskiy-rayon',
                'city_id' => 7,
            ),
            180 => 
            array (
                'id' => 185,
                'name' => 'Октябрьский район',
                'slug' => 'oktyabrskiy-rayon',
                'city_id' => 7,
            ),
            181 => 
            array (
                'id' => 186,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon-2',
                'city_id' => 7,
            ),
            182 => 
            array (
                'id' => 187,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-2',
                'city_id' => 7,
            ),
            183 => 
            array (
                'id' => 188,
                'name' => 'Железнодорожный район',
                'slug' => 'zheleznodorozhnyy-rayon-1',
                'city_id' => 7,
            ),
            184 => 
            array (
                'id' => 189,
                'name' => 'Верх-Исетский район',
                'slug' => 'verh-isetskiy-rayon',
                'city_id' => 7,
            ),
            185 => 
            array (
                'id' => 190,
                'name' => 'Советский район',
                'slug' => 'sovetskiy-rayon-3',
                'city_id' => 8,
            ),
            186 => 
            array (
                'id' => 191,
                'name' => 'Приволжский район',
                'slug' => 'privolzhskiy-rayon',
                'city_id' => 8,
            ),
            187 => 
            array (
                'id' => 192,
                'name' => 'Ново-Савиновский район',
                'slug' => 'novo-savinovskiy-rayon',
                'city_id' => 8,
            ),
            188 => 
            array (
                'id' => 193,
                'name' => 'Московский район',
                'slug' => 'moskovskiy-rayon-1',
                'city_id' => 8,
            ),
            189 => 
            array (
                'id' => 194,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-3',
                'city_id' => 8,
            ),
            190 => 
            array (
                'id' => 195,
                'name' => 'Вахитовский район',
                'slug' => 'vahitovskiy-rayon',
                'city_id' => 8,
            ),
            191 => 
            array (
                'id' => 196,
                'name' => 'Авиастроительный район',
                'slug' => 'aviastroitelnyy-rayon',
                'city_id' => 8,
            ),
            192 => 
            array (
                'id' => 197,
                'name' => 'Центральный район',
                'slug' => 'centralnyy-rayon-3',
                'city_id' => 9,
            ),
            193 => 
            array (
                'id' => 198,
                'name' => 'Прикубанский район',
                'slug' => 'prikubanskiy-rayon',
                'city_id' => 9,
            ),
            194 => 
            array (
                'id' => 199,
                'name' => 'Карасунский район',
                'slug' => 'karasunskiy-rayon',
                'city_id' => 9,
            ),
            195 => 
            array (
                'id' => 200,
                'name' => 'Западный район',
                'slug' => 'zapadnyy-rayon',
                'city_id' => 9,
            ),
            196 => 
            array (
                'id' => 201,
                'name' => 'Центральный район',
                'slug' => 'centralnyy-rayon-4',
                'city_id' => 10,
            ),
            197 => 
            array (
                'id' => 202,
                'name' => 'Советский район',
                'slug' => 'sovetskiy-rayon-4',
                'city_id' => 10,
            ),
            198 => 
            array (
                'id' => 203,
                'name' => 'Свердловский район',
                'slug' => 'sverdlovskiy-rayon',
                'city_id' => 10,
            ),
            199 => 
            array (
                'id' => 204,
                'name' => 'Октябрьский район',
                'slug' => 'oktyabrskiy-rayon-1',
                'city_id' => 10,
            ),
            200 => 
            array (
                'id' => 205,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon-3',
                'city_id' => 10,
            ),
            201 => 
            array (
                'id' => 206,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-4',
                'city_id' => 10,
            ),
            202 => 
            array (
                'id' => 207,
                'name' => 'Железнодорожный район',
                'slug' => 'zheleznodorozhnyy-rayon-2',
                'city_id' => 10,
            ),
            203 => 
            array (
                'id' => 208,
                'name' => 'район Арбат',
                'slug' => 'rayon-arbat-1',
                'city_id' => 11,
            ),
            204 => 
            array (
                'id' => 209,
                'name' => 'Басманный район',
                'slug' => 'basmannyy-rayon-1',
                'city_id' => 11,
            ),
            205 => 
            array (
                'id' => 210,
                'name' => 'район Замоскворечье',
                'slug' => 'rayon-zamoskvoreche-1',
                'city_id' => 11,
            ),
            206 => 
            array (
                'id' => 211,
                'name' => 'Красносельский район',
                'slug' => 'krasnoselskiy-rayon-2',
                'city_id' => 11,
            ),
            207 => 
            array (
                'id' => 212,
                'name' => 'Мещанский район',
                'slug' => 'meshchanskiy-rayon-1',
                'city_id' => 11,
            ),
            208 => 
            array (
                'id' => 213,
                'name' => 'Пресненский район',
                'slug' => 'presnenskiy-rayon-1',
                'city_id' => 11,
            ),
            209 => 
            array (
                'id' => 214,
                'name' => 'Таганский район',
                'slug' => 'taganskiy-rayon-1',
                'city_id' => 11,
            ),
            210 => 
            array (
                'id' => 215,
                'name' => 'Тверской район',
                'slug' => 'tverskoy-rayon-1',
                'city_id' => 11,
            ),
            211 => 
            array (
                'id' => 216,
                'name' => 'район Хамовники',
                'slug' => 'rayon-hamovniki-1',
                'city_id' => 11,
            ),
            212 => 
            array (
                'id' => 217,
                'name' => 'район Якиманка',
                'slug' => 'rayon-yakimanka-1',
                'city_id' => 11,
            ),
            213 => 
            array (
                'id' => 218,
                'name' => 'район Аэропорт',
                'slug' => 'rayon-aeroport-1',
                'city_id' => 11,
            ),
            214 => 
            array (
                'id' => 219,
                'name' => 'Беговой район',
                'slug' => 'begovoy-rayon-1',
                'city_id' => 11,
            ),
            215 => 
            array (
                'id' => 220,
                'name' => 'Бескудниковский район',
                'slug' => 'beskudnikovskiy-rayon-1',
                'city_id' => 11,
            ),
            216 => 
            array (
                'id' => 221,
                'name' => 'Войковский район',
                'slug' => 'voykovskiy-rayon-1',
                'city_id' => 11,
            ),
            217 => 
            array (
                'id' => 222,
                'name' => 'район Восточное Дегунино',
                'slug' => 'rayon-vostochnoe-degunino-1',
                'city_id' => 11,
            ),
            218 => 
            array (
                'id' => 223,
                'name' => 'Головинский район',
                'slug' => 'golovinskiy-rayon-1',
                'city_id' => 11,
            ),
            219 => 
            array (
                'id' => 224,
                'name' => 'Дмитровский район',
                'slug' => 'dmitrovskiy-rayon-1',
                'city_id' => 11,
            ),
            220 => 
            array (
                'id' => 225,
                'name' => 'район Западное Дегунино',
                'slug' => 'rayon-zapadnoe-degunino-1',
                'city_id' => 11,
            ),
            221 => 
            array (
                'id' => 226,
                'name' => 'район Коптево',
                'slug' => 'rayon-koptevo-1',
                'city_id' => 11,
            ),
            222 => 
            array (
                'id' => 227,
                'name' => 'Левобережный район',
                'slug' => 'levoberezhnyy-rayon-2',
                'city_id' => 11,
            ),
            223 => 
            array (
                'id' => 228,
                'name' => 'Молжаниновский район',
                'slug' => 'molzhaninovskiy-rayon-1',
                'city_id' => 11,
            ),
            224 => 
            array (
                'id' => 229,
                'name' => 'Савёловский район',
                'slug' => 'savelovskiy-rayon-1',
                'city_id' => 11,
            ),
            225 => 
            array (
                'id' => 230,
                'name' => 'район Сокол',
                'slug' => 'rayon-sokol-1',
                'city_id' => 11,
            ),
            226 => 
            array (
                'id' => 231,
                'name' => 'Тимирязевский район',
                'slug' => 'timiryazevskiy-rayon-1',
                'city_id' => 11,
            ),
            227 => 
            array (
                'id' => 232,
                'name' => 'район Ховрино',
                'slug' => 'rayon-hovrino-1',
                'city_id' => 11,
            ),
            228 => 
            array (
                'id' => 233,
                'name' => 'Хорошёвский район',
                'slug' => 'horoshevskiy-rayon-1',
                'city_id' => 11,
            ),
            229 => 
            array (
                'id' => 234,
                'name' => 'Алексеевский район',
                'slug' => 'alekseevskiy-rayon-1',
                'city_id' => 11,
            ),
            230 => 
            array (
                'id' => 235,
                'name' => 'Алтуфьевский район',
                'slug' => 'altufevskiy-rayon-1',
                'city_id' => 11,
            ),
            231 => 
            array (
                'id' => 236,
                'name' => 'Бабушкинский район',
                'slug' => 'babushkinskiy-rayon-1',
                'city_id' => 11,
            ),
            232 => 
            array (
                'id' => 237,
                'name' => 'район Бибирево',
                'slug' => 'rayon-bibirevo-1',
                'city_id' => 11,
            ),
            233 => 
            array (
                'id' => 238,
                'name' => 'Бутырский район',
                'slug' => 'butyrskiy-rayon-1',
                'city_id' => 11,
            ),
            234 => 
            array (
                'id' => 239,
                'name' => 'район Лианозово',
                'slug' => 'rayon-lianozovo-1',
                'city_id' => 11,
            ),
            235 => 
            array (
                'id' => 240,
                'name' => 'Лосиноостровский район',
                'slug' => 'losinoostrovskiy-rayon-1',
                'city_id' => 11,
            ),
            236 => 
            array (
                'id' => 241,
                'name' => 'район Марфино',
                'slug' => 'rayon-marfino-1',
                'city_id' => 11,
            ),
            237 => 
            array (
                'id' => 242,
                'name' => 'район Марьина Роща',
                'slug' => 'rayon-marina-roshcha-1',
                'city_id' => 11,
            ),
            238 => 
            array (
                'id' => 243,
                'name' => 'Останкинский район',
                'slug' => 'ostankinskiy-rayon-1',
                'city_id' => 11,
            ),
            239 => 
            array (
                'id' => 244,
                'name' => 'район Отрадное',
                'slug' => 'rayon-otradnoe-1',
                'city_id' => 11,
            ),
            240 => 
            array (
                'id' => 245,
                'name' => 'район Ростокино',
                'slug' => 'rayon-rostokino-1',
                'city_id' => 11,
            ),
            241 => 
            array (
                'id' => 246,
                'name' => 'район Свиблово',
                'slug' => 'rayon-sviblovo-1',
                'city_id' => 11,
            ),
            242 => 
            array (
                'id' => 247,
                'name' => 'Северный район',
                'slug' => 'severnyy-rayon-1',
                'city_id' => 11,
            ),
            243 => 
            array (
                'id' => 248,
                'name' => 'район Северное Медведково',
                'slug' => 'rayon-severnoe-medvedkovo-1',
                'city_id' => 11,
            ),
            244 => 
            array (
                'id' => 249,
                'name' => 'район Южное Медведково',
                'slug' => 'rayon-yuzhnoe-medvedkovo-1',
                'city_id' => 11,
            ),
            245 => 
            array (
                'id' => 250,
                'name' => 'Ярославский район',
                'slug' => 'yaroslavskiy-rayon-1',
                'city_id' => 11,
            ),
            246 => 
            array (
                'id' => 251,
                'name' => 'район Богородское',
                'slug' => 'rayon-bogorodskoe-1',
                'city_id' => 11,
            ),
            247 => 
            array (
                'id' => 252,
                'name' => 'район Вешняки',
                'slug' => 'rayon-veshnyaki-1',
                'city_id' => 11,
            ),
            248 => 
            array (
                'id' => 253,
                'name' => 'Восточный район',
                'slug' => 'vostochnyy-rayon-1',
                'city_id' => 11,
            ),
            249 => 
            array (
                'id' => 254,
                'name' => 'район Восточное Измайлово',
                'slug' => 'rayon-vostochnoe-izmaylovo-1',
                'city_id' => 11,
            ),
            250 => 
            array (
                'id' => 255,
                'name' => 'район Гольяново',
                'slug' => 'rayon-golyanovo-1',
                'city_id' => 11,
            ),
            251 => 
            array (
                'id' => 256,
                'name' => 'район Ивановское',
                'slug' => 'rayon-ivanovskoe-1',
                'city_id' => 11,
            ),
            252 => 
            array (
                'id' => 257,
                'name' => 'район Измайлово',
                'slug' => 'rayon-izmaylovo-1',
                'city_id' => 11,
            ),
            253 => 
            array (
                'id' => 258,
                'name' => 'Косино-Ухтомский район',
                'slug' => 'kosino-uhtomskiy-rayon-1',
                'city_id' => 11,
            ),
            254 => 
            array (
                'id' => 259,
                'name' => 'район Метрогородок',
                'slug' => 'rayon-metrogorodok-1',
                'city_id' => 11,
            ),
            255 => 
            array (
                'id' => 260,
                'name' => 'район Новогиреево',
                'slug' => 'rayon-novogireevo-1',
                'city_id' => 11,
            ),
            256 => 
            array (
                'id' => 261,
                'name' => 'район Новокосино',
                'slug' => 'rayon-novokosino-1',
                'city_id' => 11,
            ),
            257 => 
            array (
                'id' => 262,
                'name' => 'район Перово',
                'slug' => 'rayon-perovo-1',
                'city_id' => 11,
            ),
            258 => 
            array (
                'id' => 263,
                'name' => 'район Преображенское',
                'slug' => 'rayon-preobrazhenskoe-1',
                'city_id' => 11,
            ),
            259 => 
            array (
                'id' => 264,
                'name' => 'район Северное Измайлово',
                'slug' => 'rayon-severnoe-izmaylovo-1',
                'city_id' => 11,
            ),
            260 => 
            array (
                'id' => 265,
                'name' => 'район Соколиная Гора',
                'slug' => 'rayon-sokolinaya-gora-1',
                'city_id' => 11,
            ),
            261 => 
            array (
                'id' => 266,
                'name' => 'район Сокольники',
                'slug' => 'rayon-sokolniki-1',
                'city_id' => 11,
            ),
            262 => 
            array (
                'id' => 267,
                'name' => 'район Выхино-Жулебино',
                'slug' => 'rayon-vyhino-zhulebino-1',
                'city_id' => 11,
            ),
            263 => 
            array (
                'id' => 268,
                'name' => 'район Капотня',
                'slug' => 'rayon-kapotnya-1',
                'city_id' => 11,
            ),
            264 => 
            array (
                'id' => 269,
                'name' => 'район Кузьминки',
                'slug' => 'rayon-kuzminki-1',
                'city_id' => 11,
            ),
            265 => 
            array (
                'id' => 270,
                'name' => 'район Лефортово',
                'slug' => 'rayon-lefortovo-1',
                'city_id' => 11,
            ),
            266 => 
            array (
                'id' => 271,
                'name' => 'район Люблино',
                'slug' => 'rayon-lyublino-1',
                'city_id' => 11,
            ),
            267 => 
            array (
                'id' => 272,
                'name' => 'район Марьино',
                'slug' => 'rayon-marino-1',
                'city_id' => 11,
            ),
            268 => 
            array (
                'id' => 273,
                'name' => 'район Некрасовка',
                'slug' => 'rayon-nekrasovka-1',
                'city_id' => 11,
            ),
            269 => 
            array (
                'id' => 274,
                'name' => 'Нижегородский район',
                'slug' => 'nizhegorodskiy-rayon-1',
                'city_id' => 11,
            ),
            270 => 
            array (
                'id' => 275,
                'name' => 'район Печатники',
                'slug' => 'rayon-pechatniki-1',
                'city_id' => 11,
            ),
            271 => 
            array (
                'id' => 276,
                'name' => 'Рязанский район',
                'slug' => 'ryazanskiy-rayon-1',
                'city_id' => 11,
            ),
            272 => 
            array (
                'id' => 277,
                'name' => 'район Текстильщики',
                'slug' => 'rayon-tekstilshchiki-1',
                'city_id' => 11,
            ),
            273 => 
            array (
                'id' => 278,
                'name' => 'Южнопортовый район',
                'slug' => 'yuzhnoportovyy-rayon-1',
                'city_id' => 11,
            ),
            274 => 
            array (
                'id' => 279,
                'name' => 'район Бирюлёво Восточное',
                'slug' => 'rayon-biryulevo-vostochnoe-1',
                'city_id' => 11,
            ),
            275 => 
            array (
                'id' => 280,
                'name' => 'район Бирюлёво Западное',
                'slug' => 'rayon-biryulevo-zapadnoe-1',
                'city_id' => 11,
            ),
            276 => 
            array (
                'id' => 281,
                'name' => 'район Братеево',
                'slug' => 'rayon-brateevo-1',
                'city_id' => 11,
            ),
            277 => 
            array (
                'id' => 282,
                'name' => 'Даниловский район',
                'slug' => 'danilovskiy-rayon-1',
                'city_id' => 11,
            ),
            278 => 
            array (
                'id' => 283,
                'name' => 'Донской район',
                'slug' => 'donskoy-rayon-1',
                'city_id' => 11,
            ),
            279 => 
            array (
                'id' => 284,
                'name' => 'район Зябликово',
                'slug' => 'rayon-zyablikovo-1',
                'city_id' => 11,
            ),
            280 => 
            array (
                'id' => 285,
                'name' => 'район Москворечье-Сабурово',
                'slug' => 'rayon-moskvoreche-saburovo-1',
                'city_id' => 11,
            ),
            281 => 
            array (
                'id' => 286,
                'name' => 'район Нагатино-Садовники',
                'slug' => 'rayon-nagatino-sadovniki-1',
                'city_id' => 11,
            ),
            282 => 
            array (
                'id' => 287,
                'name' => 'район Нагатинский Затон',
                'slug' => 'rayon-nagatinskiy-zaton-1',
                'city_id' => 11,
            ),
            283 => 
            array (
                'id' => 288,
                'name' => 'Нагорный район',
                'slug' => 'nagornyy-rayon-1',
                'city_id' => 11,
            ),
            284 => 
            array (
                'id' => 289,
                'name' => 'район Орехово-Борисово Северное',
                'slug' => 'rayon-orehovo-borisovo-severnoe-1',
                'city_id' => 11,
            ),
            285 => 
            array (
                'id' => 290,
                'name' => 'район Орехово-Борисово Южное',
                'slug' => 'rayon-orehovo-borisovo-yuzhnoe-1',
                'city_id' => 11,
            ),
            286 => 
            array (
                'id' => 291,
                'name' => 'район Царицыно',
                'slug' => 'rayon-caricyno-1',
                'city_id' => 11,
            ),
            287 => 
            array (
                'id' => 292,
                'name' => 'район Чертаново Северное',
                'slug' => 'rayon-chertanovo-severnoe-1',
                'city_id' => 11,
            ),
            288 => 
            array (
                'id' => 293,
                'name' => 'район Чертаново Центральное',
                'slug' => 'rayon-chertanovo-centralnoe-1',
                'city_id' => 11,
            ),
            289 => 
            array (
                'id' => 294,
                'name' => 'район Чертаново Южное',
                'slug' => 'rayon-chertanovo-yuzhnoe-1',
                'city_id' => 11,
            ),
            290 => 
            array (
                'id' => 295,
                'name' => 'Академический район',
                'slug' => 'akademicheskiy-rayon-1',
                'city_id' => 11,
            ),
            291 => 
            array (
                'id' => 296,
                'name' => 'Гагаринский район',
                'slug' => 'gagarinskiy-rayon-1',
                'city_id' => 11,
            ),
            292 => 
            array (
                'id' => 297,
                'name' => 'район Зюзино',
                'slug' => 'rayon-zyuzino-1',
                'city_id' => 11,
            ),
            293 => 
            array (
                'id' => 298,
                'name' => 'район Коньково',
                'slug' => 'rayon-konkovo-1',
                'city_id' => 11,
            ),
            294 => 
            array (
                'id' => 299,
                'name' => 'район Котловка',
                'slug' => 'rayon-kotlovka-1',
                'city_id' => 11,
            ),
            295 => 
            array (
                'id' => 300,
                'name' => 'Ломоносовский район',
                'slug' => 'lomonosovskiy-rayon-1',
                'city_id' => 11,
            ),
            296 => 
            array (
                'id' => 301,
                'name' => 'Обручевский район',
                'slug' => 'obruchevskiy-rayon-1',
                'city_id' => 11,
            ),
            297 => 
            array (
                'id' => 302,
                'name' => 'район Северное Бутово',
                'slug' => 'rayon-severnoe-butovo-1',
                'city_id' => 11,
            ),
            298 => 
            array (
                'id' => 303,
                'name' => 'район Тёплый Стан',
                'slug' => 'rayon-teplyy-stan-1',
                'city_id' => 11,
            ),
            299 => 
            array (
                'id' => 304,
                'name' => 'район Черёмушки',
                'slug' => 'rayon-cheremushki-1',
                'city_id' => 11,
            ),
            300 => 
            array (
                'id' => 305,
                'name' => 'район Южное Бутово',
                'slug' => 'rayon-yuzhnoe-butovo-1',
                'city_id' => 11,
            ),
            301 => 
            array (
                'id' => 306,
                'name' => 'район Ясенево',
                'slug' => 'rayon-yasenevo-1',
                'city_id' => 11,
            ),
            302 => 
            array (
                'id' => 307,
                'name' => 'район Дорогомилово',
                'slug' => 'rayon-dorogomilovo-1',
                'city_id' => 11,
            ),
            303 => 
            array (
                'id' => 308,
                'name' => 'район Крылатское',
                'slug' => 'rayon-krylatskoe-1',
                'city_id' => 11,
            ),
            304 => 
            array (
                'id' => 309,
                'name' => 'район Кунцево',
                'slug' => 'rayon-kuncevo-1',
                'city_id' => 11,
            ),
            305 => 
            array (
                'id' => 310,
                'name' => 'Можайский район',
                'slug' => 'mozhayskiy-rayon-1',
                'city_id' => 11,
            ),
            306 => 
            array (
                'id' => 311,
                'name' => 'район Ново-Переделкино',
                'slug' => 'rayon-novo-peredelkino-1',
                'city_id' => 11,
            ),
            307 => 
            array (
                'id' => 312,
                'name' => 'район Очаково-Матвеевское',
                'slug' => 'rayon-ochakovo-matveevskoe-1',
                'city_id' => 11,
            ),
            308 => 
            array (
                'id' => 313,
                'name' => 'район Проспект Вернадского',
                'slug' => 'rayon-prospekt-vernadskogo-1',
                'city_id' => 11,
            ),
            309 => 
            array (
                'id' => 314,
                'name' => 'район Раменки',
                'slug' => 'rayon-ramenki-1',
                'city_id' => 11,
            ),
            310 => 
            array (
                'id' => 315,
                'name' => 'район Солнцево',
                'slug' => 'rayon-solncevo-1',
                'city_id' => 11,
            ),
            311 => 
            array (
                'id' => 316,
                'name' => 'район Тропарёво-Никулино',
                'slug' => 'rayon-troparevo-nikulino-1',
                'city_id' => 11,
            ),
            312 => 
            array (
                'id' => 317,
                'name' => 'район Филёвский Парк',
                'slug' => 'rayon-filevskiy-park-1',
                'city_id' => 11,
            ),
            313 => 
            array (
                'id' => 318,
                'name' => 'район Фили-Давыдково',
                'slug' => 'rayon-fili-davydkovo-1',
                'city_id' => 11,
            ),
            314 => 
            array (
                'id' => 319,
                'name' => 'район Куркино',
                'slug' => 'rayon-kurkino-1',
                'city_id' => 11,
            ),
            315 => 
            array (
                'id' => 320,
                'name' => 'район Митино',
                'slug' => 'rayon-mitino-1',
                'city_id' => 11,
            ),
            316 => 
            array (
                'id' => 321,
                'name' => 'район Покровское-Стрешнево',
                'slug' => 'rayon-pokrovskoe-streshnevo-1',
                'city_id' => 11,
            ),
            317 => 
            array (
                'id' => 322,
                'name' => 'район Северное Тушино',
                'slug' => 'rayon-severnoe-tushino-1',
                'city_id' => 11,
            ),
            318 => 
            array (
                'id' => 323,
                'name' => 'район Хорошёво-Мнёвники',
                'slug' => 'rayon-horoshevo-mnevniki-1',
                'city_id' => 11,
            ),
            319 => 
            array (
                'id' => 324,
                'name' => 'район Щукино',
                'slug' => 'rayon-shchukino-1',
                'city_id' => 11,
            ),
            320 => 
            array (
                'id' => 325,
                'name' => 'район Южное Тушино',
                'slug' => 'rayon-yuzhnoe-tushino-1',
                'city_id' => 11,
            ),
            321 => 
            array (
                'id' => 326,
                'name' => 'район Строгино',
                'slug' => 'rayon-strogino-1',
                'city_id' => 11,
            ),
            322 => 
            array (
                'id' => 327,
                'name' => 'район СП Внуковское',
                'slug' => 'rayon-sp-vnukovskoe-1',
                'city_id' => 11,
            ),
            323 => 
            array (
                'id' => 328,
                'name' => 'район СП Воскресенское',
                'slug' => 'rayon-sp-voskresenskoe-1',
                'city_id' => 11,
            ),
            324 => 
            array (
                'id' => 329,
                'name' => 'район СП Десёновское',
                'slug' => 'rayon-sp-desenovskoe-1',
                'city_id' => 11,
            ),
            325 => 
            array (
                'id' => 330,
                'name' => 'район СП Кокошкино',
                'slug' => 'rayon-sp-kokoshkino-1',
                'city_id' => 11,
            ),
            326 => 
            array (
                'id' => 331,
                'name' => 'район СП Марушкинское',
                'slug' => 'rayon-sp-marushkinskoe-1',
                'city_id' => 11,
            ),
            327 => 
            array (
                'id' => 332,
                'name' => 'район СП Московский',
                'slug' => 'rayon-sp-moskovskiy-1',
                'city_id' => 11,
            ),
            328 => 
            array (
                'id' => 333,
                'name' => 'район СП Мосрентген',
                'slug' => 'rayon-sp-mosrentgen-1',
                'city_id' => 11,
            ),
            329 => 
            array (
                'id' => 334,
                'name' => 'район СП Рязановское',
                'slug' => 'rayon-sp-ryazanovskoe-1',
                'city_id' => 11,
            ),
            330 => 
            array (
                'id' => 335,
                'name' => 'район СП Сосенское',
                'slug' => 'rayon-sp-sosenskoe-1',
                'city_id' => 11,
            ),
            331 => 
            array (
                'id' => 336,
                'name' => 'район СП Филимонковское',
                'slug' => 'rayon-sp-filimonkovskoe-1',
                'city_id' => 11,
            ),
            332 => 
            array (
                'id' => 337,
                'name' => 'район ГО Щербинка',
                'slug' => 'rayon-go-shcherbinka-1',
                'city_id' => 11,
            ),
            333 => 
            array (
                'id' => 338,
                'name' => 'район СП Вороновское',
                'slug' => 'rayon-sp-voronovskoe-1',
                'city_id' => 11,
            ),
            334 => 
            array (
                'id' => 339,
                'name' => 'район СП Киевский',
                'slug' => 'rayon-sp-kievskiy-1',
                'city_id' => 11,
            ),
            335 => 
            array (
                'id' => 340,
                'name' => 'район СП Клёновское',
                'slug' => 'rayon-sp-klenovskoe-1',
                'city_id' => 11,
            ),
            336 => 
            array (
                'id' => 341,
                'name' => 'район СП Краснопахорское',
                'slug' => 'rayon-sp-krasnopahorskoe-1',
                'city_id' => 11,
            ),
            337 => 
            array (
                'id' => 342,
                'name' => 'район СП Михайлово-Ярцевское',
                'slug' => 'rayon-sp-mihaylovo-yarcevskoe-1',
                'city_id' => 11,
            ),
            338 => 
            array (
                'id' => 343,
                'name' => 'район СП Новофёдоровское',
                'slug' => 'rayon-sp-novofedorovskoe-1',
                'city_id' => 11,
            ),
            339 => 
            array (
                'id' => 344,
                'name' => 'район СП Первомайское',
                'slug' => 'rayon-sp-pervomayskoe-1',
                'city_id' => 11,
            ),
            340 => 
            array (
                'id' => 345,
                'name' => 'район СП Роговское',
                'slug' => 'rayon-sp-rogovskoe-1',
                'city_id' => 11,
            ),
            341 => 
            array (
                'id' => 346,
                'name' => 'район ГО Троицк',
                'slug' => 'rayon-go-troick-1',
                'city_id' => 11,
            ),
            342 => 
            array (
                'id' => 347,
                'name' => 'район СП Щаповское',
                'slug' => 'rayon-sp-shchapovskoe-1',
                'city_id' => 11,
            ),
            343 => 
            array (
                'id' => 348,
                'name' => 'район Арбат',
                'slug' => 'rayon-arbat-2',
                'city_id' => 12,
            ),
            344 => 
            array (
                'id' => 349,
                'name' => 'Басманный район',
                'slug' => 'basmannyy-rayon-2',
                'city_id' => 12,
            ),
            345 => 
            array (
                'id' => 350,
                'name' => 'район Замоскворечье',
                'slug' => 'rayon-zamoskvoreche-2',
                'city_id' => 12,
            ),
            346 => 
            array (
                'id' => 351,
                'name' => 'Красносельский район',
                'slug' => 'krasnoselskiy-rayon-3',
                'city_id' => 12,
            ),
            347 => 
            array (
                'id' => 352,
                'name' => 'Мещанский район',
                'slug' => 'meshchanskiy-rayon-2',
                'city_id' => 12,
            ),
            348 => 
            array (
                'id' => 353,
                'name' => 'Пресненский район',
                'slug' => 'presnenskiy-rayon-2',
                'city_id' => 12,
            ),
            349 => 
            array (
                'id' => 354,
                'name' => 'Таганский район',
                'slug' => 'taganskiy-rayon-2',
                'city_id' => 12,
            ),
            350 => 
            array (
                'id' => 355,
                'name' => 'Тверской район',
                'slug' => 'tverskoy-rayon-2',
                'city_id' => 12,
            ),
            351 => 
            array (
                'id' => 356,
                'name' => 'район Хамовники',
                'slug' => 'rayon-hamovniki-2',
                'city_id' => 12,
            ),
            352 => 
            array (
                'id' => 357,
                'name' => 'район Якиманка',
                'slug' => 'rayon-yakimanka-2',
                'city_id' => 12,
            ),
            353 => 
            array (
                'id' => 358,
                'name' => 'район Аэропорт',
                'slug' => 'rayon-aeroport-2',
                'city_id' => 12,
            ),
            354 => 
            array (
                'id' => 359,
                'name' => 'Беговой район',
                'slug' => 'begovoy-rayon-2',
                'city_id' => 12,
            ),
            355 => 
            array (
                'id' => 360,
                'name' => 'Бескудниковский район',
                'slug' => 'beskudnikovskiy-rayon-2',
                'city_id' => 12,
            ),
            356 => 
            array (
                'id' => 361,
                'name' => 'Войковский район',
                'slug' => 'voykovskiy-rayon-2',
                'city_id' => 12,
            ),
            357 => 
            array (
                'id' => 362,
                'name' => 'район Восточное Дегунино',
                'slug' => 'rayon-vostochnoe-degunino-2',
                'city_id' => 12,
            ),
            358 => 
            array (
                'id' => 363,
                'name' => 'Головинский район',
                'slug' => 'golovinskiy-rayon-2',
                'city_id' => 12,
            ),
            359 => 
            array (
                'id' => 364,
                'name' => 'Дмитровский район',
                'slug' => 'dmitrovskiy-rayon-2',
                'city_id' => 12,
            ),
            360 => 
            array (
                'id' => 365,
                'name' => 'район Западное Дегунино',
                'slug' => 'rayon-zapadnoe-degunino-2',
                'city_id' => 12,
            ),
            361 => 
            array (
                'id' => 366,
                'name' => 'район Коптево',
                'slug' => 'rayon-koptevo-2',
                'city_id' => 12,
            ),
            362 => 
            array (
                'id' => 367,
                'name' => 'Левобережный район',
                'slug' => 'levoberezhnyy-rayon-3',
                'city_id' => 12,
            ),
            363 => 
            array (
                'id' => 368,
                'name' => 'Молжаниновский район',
                'slug' => 'molzhaninovskiy-rayon-2',
                'city_id' => 12,
            ),
            364 => 
            array (
                'id' => 369,
                'name' => 'Савёловский район',
                'slug' => 'savelovskiy-rayon-2',
                'city_id' => 12,
            ),
            365 => 
            array (
                'id' => 370,
                'name' => 'район Сокол',
                'slug' => 'rayon-sokol-2',
                'city_id' => 12,
            ),
            366 => 
            array (
                'id' => 371,
                'name' => 'Тимирязевский район',
                'slug' => 'timiryazevskiy-rayon-2',
                'city_id' => 12,
            ),
            367 => 
            array (
                'id' => 372,
                'name' => 'район Ховрино',
                'slug' => 'rayon-hovrino-2',
                'city_id' => 12,
            ),
            368 => 
            array (
                'id' => 373,
                'name' => 'Хорошёвский район',
                'slug' => 'horoshevskiy-rayon-2',
                'city_id' => 12,
            ),
            369 => 
            array (
                'id' => 374,
                'name' => 'Алексеевский район',
                'slug' => 'alekseevskiy-rayon-2',
                'city_id' => 12,
            ),
            370 => 
            array (
                'id' => 375,
                'name' => 'Алтуфьевский район',
                'slug' => 'altufevskiy-rayon-2',
                'city_id' => 12,
            ),
            371 => 
            array (
                'id' => 376,
                'name' => 'Бабушкинский район',
                'slug' => 'babushkinskiy-rayon-2',
                'city_id' => 12,
            ),
            372 => 
            array (
                'id' => 377,
                'name' => 'район Бибирево',
                'slug' => 'rayon-bibirevo-2',
                'city_id' => 12,
            ),
            373 => 
            array (
                'id' => 378,
                'name' => 'Бутырский район',
                'slug' => 'butyrskiy-rayon-2',
                'city_id' => 12,
            ),
            374 => 
            array (
                'id' => 379,
                'name' => 'район Лианозово',
                'slug' => 'rayon-lianozovo-2',
                'city_id' => 12,
            ),
            375 => 
            array (
                'id' => 380,
                'name' => 'Лосиноостровский район',
                'slug' => 'losinoostrovskiy-rayon-2',
                'city_id' => 12,
            ),
            376 => 
            array (
                'id' => 381,
                'name' => 'район Марфино',
                'slug' => 'rayon-marfino-2',
                'city_id' => 12,
            ),
            377 => 
            array (
                'id' => 382,
                'name' => 'район Марьина Роща',
                'slug' => 'rayon-marina-roshcha-2',
                'city_id' => 12,
            ),
            378 => 
            array (
                'id' => 383,
                'name' => 'Останкинский район',
                'slug' => 'ostankinskiy-rayon-2',
                'city_id' => 12,
            ),
            379 => 
            array (
                'id' => 384,
                'name' => 'район Отрадное',
                'slug' => 'rayon-otradnoe-2',
                'city_id' => 12,
            ),
            380 => 
            array (
                'id' => 385,
                'name' => 'район Ростокино',
                'slug' => 'rayon-rostokino-2',
                'city_id' => 12,
            ),
            381 => 
            array (
                'id' => 386,
                'name' => 'район Свиблово',
                'slug' => 'rayon-sviblovo-2',
                'city_id' => 12,
            ),
            382 => 
            array (
                'id' => 387,
                'name' => 'Северный район',
                'slug' => 'severnyy-rayon-2',
                'city_id' => 12,
            ),
            383 => 
            array (
                'id' => 388,
                'name' => 'район Северное Медведково',
                'slug' => 'rayon-severnoe-medvedkovo-2',
                'city_id' => 12,
            ),
            384 => 
            array (
                'id' => 389,
                'name' => 'район Южное Медведково',
                'slug' => 'rayon-yuzhnoe-medvedkovo-2',
                'city_id' => 12,
            ),
            385 => 
            array (
                'id' => 390,
                'name' => 'Ярославский район',
                'slug' => 'yaroslavskiy-rayon-2',
                'city_id' => 12,
            ),
            386 => 
            array (
                'id' => 391,
                'name' => 'район Богородское',
                'slug' => 'rayon-bogorodskoe-2',
                'city_id' => 12,
            ),
            387 => 
            array (
                'id' => 392,
                'name' => 'район Вешняки',
                'slug' => 'rayon-veshnyaki-2',
                'city_id' => 12,
            ),
            388 => 
            array (
                'id' => 393,
                'name' => 'Восточный район',
                'slug' => 'vostochnyy-rayon-2',
                'city_id' => 12,
            ),
            389 => 
            array (
                'id' => 394,
                'name' => 'район Восточное Измайлово',
                'slug' => 'rayon-vostochnoe-izmaylovo-2',
                'city_id' => 12,
            ),
            390 => 
            array (
                'id' => 395,
                'name' => 'район Гольяново',
                'slug' => 'rayon-golyanovo-2',
                'city_id' => 12,
            ),
            391 => 
            array (
                'id' => 396,
                'name' => 'район Ивановское',
                'slug' => 'rayon-ivanovskoe-2',
                'city_id' => 12,
            ),
            392 => 
            array (
                'id' => 397,
                'name' => 'район Измайлово',
                'slug' => 'rayon-izmaylovo-2',
                'city_id' => 12,
            ),
            393 => 
            array (
                'id' => 398,
                'name' => 'Косино-Ухтомский район',
                'slug' => 'kosino-uhtomskiy-rayon-2',
                'city_id' => 12,
            ),
            394 => 
            array (
                'id' => 399,
                'name' => 'район Метрогородок',
                'slug' => 'rayon-metrogorodok-2',
                'city_id' => 12,
            ),
            395 => 
            array (
                'id' => 400,
                'name' => 'район Новогиреево',
                'slug' => 'rayon-novogireevo-2',
                'city_id' => 12,
            ),
            396 => 
            array (
                'id' => 401,
                'name' => 'район Новокосино',
                'slug' => 'rayon-novokosino-2',
                'city_id' => 12,
            ),
            397 => 
            array (
                'id' => 402,
                'name' => 'район Перово',
                'slug' => 'rayon-perovo-2',
                'city_id' => 12,
            ),
            398 => 
            array (
                'id' => 403,
                'name' => 'район Преображенское',
                'slug' => 'rayon-preobrazhenskoe-2',
                'city_id' => 12,
            ),
            399 => 
            array (
                'id' => 404,
                'name' => 'район Северное Измайлово',
                'slug' => 'rayon-severnoe-izmaylovo-2',
                'city_id' => 12,
            ),
            400 => 
            array (
                'id' => 405,
                'name' => 'район Соколиная Гора',
                'slug' => 'rayon-sokolinaya-gora-2',
                'city_id' => 12,
            ),
            401 => 
            array (
                'id' => 406,
                'name' => 'район Сокольники',
                'slug' => 'rayon-sokolniki-2',
                'city_id' => 12,
            ),
            402 => 
            array (
                'id' => 407,
                'name' => 'район Выхино-Жулебино',
                'slug' => 'rayon-vyhino-zhulebino-2',
                'city_id' => 12,
            ),
            403 => 
            array (
                'id' => 408,
                'name' => 'район Капотня',
                'slug' => 'rayon-kapotnya-2',
                'city_id' => 12,
            ),
            404 => 
            array (
                'id' => 409,
                'name' => 'район Кузьминки',
                'slug' => 'rayon-kuzminki-2',
                'city_id' => 12,
            ),
            405 => 
            array (
                'id' => 410,
                'name' => 'район Лефортово',
                'slug' => 'rayon-lefortovo-2',
                'city_id' => 12,
            ),
            406 => 
            array (
                'id' => 411,
                'name' => 'район Люблино',
                'slug' => 'rayon-lyublino-2',
                'city_id' => 12,
            ),
            407 => 
            array (
                'id' => 412,
                'name' => 'район Марьино',
                'slug' => 'rayon-marino-2',
                'city_id' => 12,
            ),
            408 => 
            array (
                'id' => 413,
                'name' => 'район Некрасовка',
                'slug' => 'rayon-nekrasovka-2',
                'city_id' => 12,
            ),
            409 => 
            array (
                'id' => 414,
                'name' => 'Нижегородский район',
                'slug' => 'nizhegorodskiy-rayon-2',
                'city_id' => 12,
            ),
            410 => 
            array (
                'id' => 415,
                'name' => 'район Печатники',
                'slug' => 'rayon-pechatniki-2',
                'city_id' => 12,
            ),
            411 => 
            array (
                'id' => 416,
                'name' => 'Рязанский район',
                'slug' => 'ryazanskiy-rayon-2',
                'city_id' => 12,
            ),
            412 => 
            array (
                'id' => 417,
                'name' => 'район Текстильщики',
                'slug' => 'rayon-tekstilshchiki-2',
                'city_id' => 12,
            ),
            413 => 
            array (
                'id' => 418,
                'name' => 'Южнопортовый район',
                'slug' => 'yuzhnoportovyy-rayon-2',
                'city_id' => 12,
            ),
            414 => 
            array (
                'id' => 419,
                'name' => 'район Бирюлёво Восточное',
                'slug' => 'rayon-biryulevo-vostochnoe-2',
                'city_id' => 12,
            ),
            415 => 
            array (
                'id' => 420,
                'name' => 'район Бирюлёво Западное',
                'slug' => 'rayon-biryulevo-zapadnoe-2',
                'city_id' => 12,
            ),
            416 => 
            array (
                'id' => 421,
                'name' => 'район Братеево',
                'slug' => 'rayon-brateevo-2',
                'city_id' => 12,
            ),
            417 => 
            array (
                'id' => 422,
                'name' => 'Даниловский район',
                'slug' => 'danilovskiy-rayon-2',
                'city_id' => 12,
            ),
            418 => 
            array (
                'id' => 423,
                'name' => 'Донской район',
                'slug' => 'donskoy-rayon-2',
                'city_id' => 12,
            ),
            419 => 
            array (
                'id' => 424,
                'name' => 'район Зябликово',
                'slug' => 'rayon-zyablikovo-2',
                'city_id' => 12,
            ),
            420 => 
            array (
                'id' => 425,
                'name' => 'район Москворечье-Сабурово',
                'slug' => 'rayon-moskvoreche-saburovo-2',
                'city_id' => 12,
            ),
            421 => 
            array (
                'id' => 426,
                'name' => 'район Нагатино-Садовники',
                'slug' => 'rayon-nagatino-sadovniki-2',
                'city_id' => 12,
            ),
            422 => 
            array (
                'id' => 427,
                'name' => 'район Нагатинский Затон',
                'slug' => 'rayon-nagatinskiy-zaton-2',
                'city_id' => 12,
            ),
            423 => 
            array (
                'id' => 428,
                'name' => 'Нагорный район',
                'slug' => 'nagornyy-rayon-2',
                'city_id' => 12,
            ),
            424 => 
            array (
                'id' => 429,
                'name' => 'район Орехово-Борисово Северное',
                'slug' => 'rayon-orehovo-borisovo-severnoe-2',
                'city_id' => 12,
            ),
            425 => 
            array (
                'id' => 430,
                'name' => 'район Орехово-Борисово Южное',
                'slug' => 'rayon-orehovo-borisovo-yuzhnoe-2',
                'city_id' => 12,
            ),
            426 => 
            array (
                'id' => 431,
                'name' => 'район Царицыно',
                'slug' => 'rayon-caricyno-2',
                'city_id' => 12,
            ),
            427 => 
            array (
                'id' => 432,
                'name' => 'район Чертаново Северное',
                'slug' => 'rayon-chertanovo-severnoe-2',
                'city_id' => 12,
            ),
            428 => 
            array (
                'id' => 433,
                'name' => 'район Чертаново Центральное',
                'slug' => 'rayon-chertanovo-centralnoe-2',
                'city_id' => 12,
            ),
            429 => 
            array (
                'id' => 434,
                'name' => 'район Чертаново Южное',
                'slug' => 'rayon-chertanovo-yuzhnoe-2',
                'city_id' => 12,
            ),
            430 => 
            array (
                'id' => 435,
                'name' => 'Академический район',
                'slug' => 'akademicheskiy-rayon-2',
                'city_id' => 12,
            ),
            431 => 
            array (
                'id' => 436,
                'name' => 'Гагаринский район',
                'slug' => 'gagarinskiy-rayon-2',
                'city_id' => 12,
            ),
            432 => 
            array (
                'id' => 437,
                'name' => 'район Зюзино',
                'slug' => 'rayon-zyuzino-2',
                'city_id' => 12,
            ),
            433 => 
            array (
                'id' => 438,
                'name' => 'район Коньково',
                'slug' => 'rayon-konkovo-2',
                'city_id' => 12,
            ),
            434 => 
            array (
                'id' => 439,
                'name' => 'район Котловка',
                'slug' => 'rayon-kotlovka-2',
                'city_id' => 12,
            ),
            435 => 
            array (
                'id' => 440,
                'name' => 'Ломоносовский район',
                'slug' => 'lomonosovskiy-rayon-2',
                'city_id' => 12,
            ),
            436 => 
            array (
                'id' => 441,
                'name' => 'Обручевский район',
                'slug' => 'obruchevskiy-rayon-2',
                'city_id' => 12,
            ),
            437 => 
            array (
                'id' => 442,
                'name' => 'район Северное Бутово',
                'slug' => 'rayon-severnoe-butovo-2',
                'city_id' => 12,
            ),
            438 => 
            array (
                'id' => 443,
                'name' => 'район Тёплый Стан',
                'slug' => 'rayon-teplyy-stan-2',
                'city_id' => 12,
            ),
            439 => 
            array (
                'id' => 444,
                'name' => 'район Черёмушки',
                'slug' => 'rayon-cheremushki-2',
                'city_id' => 12,
            ),
            440 => 
            array (
                'id' => 445,
                'name' => 'район Южное Бутово',
                'slug' => 'rayon-yuzhnoe-butovo-2',
                'city_id' => 12,
            ),
            441 => 
            array (
                'id' => 446,
                'name' => 'район Ясенево',
                'slug' => 'rayon-yasenevo-2',
                'city_id' => 12,
            ),
            442 => 
            array (
                'id' => 447,
                'name' => 'район Дорогомилово',
                'slug' => 'rayon-dorogomilovo-2',
                'city_id' => 12,
            ),
            443 => 
            array (
                'id' => 448,
                'name' => 'район Крылатское',
                'slug' => 'rayon-krylatskoe-2',
                'city_id' => 12,
            ),
            444 => 
            array (
                'id' => 449,
                'name' => 'район Кунцево',
                'slug' => 'rayon-kuncevo-2',
                'city_id' => 12,
            ),
            445 => 
            array (
                'id' => 450,
                'name' => 'Можайский район',
                'slug' => 'mozhayskiy-rayon-2',
                'city_id' => 12,
            ),
            446 => 
            array (
                'id' => 451,
                'name' => 'район Ново-Переделкино',
                'slug' => 'rayon-novo-peredelkino-2',
                'city_id' => 12,
            ),
            447 => 
            array (
                'id' => 452,
                'name' => 'район Очаково-Матвеевское',
                'slug' => 'rayon-ochakovo-matveevskoe-2',
                'city_id' => 12,
            ),
            448 => 
            array (
                'id' => 453,
                'name' => 'район Проспект Вернадского',
                'slug' => 'rayon-prospekt-vernadskogo-2',
                'city_id' => 12,
            ),
            449 => 
            array (
                'id' => 454,
                'name' => 'район Раменки',
                'slug' => 'rayon-ramenki-2',
                'city_id' => 12,
            ),
            450 => 
            array (
                'id' => 455,
                'name' => 'район Солнцево',
                'slug' => 'rayon-solncevo-2',
                'city_id' => 12,
            ),
            451 => 
            array (
                'id' => 456,
                'name' => 'район Тропарёво-Никулино',
                'slug' => 'rayon-troparevo-nikulino-2',
                'city_id' => 12,
            ),
            452 => 
            array (
                'id' => 457,
                'name' => 'район Филёвский Парк',
                'slug' => 'rayon-filevskiy-park-2',
                'city_id' => 12,
            ),
            453 => 
            array (
                'id' => 458,
                'name' => 'район Фили-Давыдково',
                'slug' => 'rayon-fili-davydkovo-2',
                'city_id' => 12,
            ),
            454 => 
            array (
                'id' => 459,
                'name' => 'район Куркино',
                'slug' => 'rayon-kurkino-2',
                'city_id' => 12,
            ),
            455 => 
            array (
                'id' => 460,
                'name' => 'район Митино',
                'slug' => 'rayon-mitino-2',
                'city_id' => 12,
            ),
            456 => 
            array (
                'id' => 461,
                'name' => 'район Покровское-Стрешнево',
                'slug' => 'rayon-pokrovskoe-streshnevo-2',
                'city_id' => 12,
            ),
            457 => 
            array (
                'id' => 462,
                'name' => 'район Северное Тушино',
                'slug' => 'rayon-severnoe-tushino-2',
                'city_id' => 12,
            ),
            458 => 
            array (
                'id' => 463,
                'name' => 'район Хорошёво-Мнёвники',
                'slug' => 'rayon-horoshevo-mnevniki-2',
                'city_id' => 12,
            ),
            459 => 
            array (
                'id' => 464,
                'name' => 'район Щукино',
                'slug' => 'rayon-shchukino-2',
                'city_id' => 12,
            ),
            460 => 
            array (
                'id' => 465,
                'name' => 'район Южное Тушино',
                'slug' => 'rayon-yuzhnoe-tushino-2',
                'city_id' => 12,
            ),
            461 => 
            array (
                'id' => 466,
                'name' => 'район Строгино',
                'slug' => 'rayon-strogino-2',
                'city_id' => 12,
            ),
            462 => 
            array (
                'id' => 467,
                'name' => 'район СП Внуковское',
                'slug' => 'rayon-sp-vnukovskoe-2',
                'city_id' => 12,
            ),
            463 => 
            array (
                'id' => 468,
                'name' => 'район СП Воскресенское',
                'slug' => 'rayon-sp-voskresenskoe-2',
                'city_id' => 12,
            ),
            464 => 
            array (
                'id' => 469,
                'name' => 'район СП Десёновское',
                'slug' => 'rayon-sp-desenovskoe-2',
                'city_id' => 12,
            ),
            465 => 
            array (
                'id' => 470,
                'name' => 'район СП Кокошкино',
                'slug' => 'rayon-sp-kokoshkino-2',
                'city_id' => 12,
            ),
            466 => 
            array (
                'id' => 471,
                'name' => 'район СП Марушкинское',
                'slug' => 'rayon-sp-marushkinskoe-2',
                'city_id' => 12,
            ),
            467 => 
            array (
                'id' => 472,
                'name' => 'район СП Московский',
                'slug' => 'rayon-sp-moskovskiy-2',
                'city_id' => 12,
            ),
            468 => 
            array (
                'id' => 473,
                'name' => 'район СП Мосрентген',
                'slug' => 'rayon-sp-mosrentgen-2',
                'city_id' => 12,
            ),
            469 => 
            array (
                'id' => 474,
                'name' => 'район СП Рязановское',
                'slug' => 'rayon-sp-ryazanovskoe-2',
                'city_id' => 12,
            ),
            470 => 
            array (
                'id' => 475,
                'name' => 'район СП Сосенское',
                'slug' => 'rayon-sp-sosenskoe-2',
                'city_id' => 12,
            ),
            471 => 
            array (
                'id' => 476,
                'name' => 'район СП Филимонковское',
                'slug' => 'rayon-sp-filimonkovskoe-2',
                'city_id' => 12,
            ),
            472 => 
            array (
                'id' => 477,
                'name' => 'район ГО Щербинка',
                'slug' => 'rayon-go-shcherbinka-2',
                'city_id' => 12,
            ),
            473 => 
            array (
                'id' => 478,
                'name' => 'район СП Вороновское',
                'slug' => 'rayon-sp-voronovskoe-2',
                'city_id' => 12,
            ),
            474 => 
            array (
                'id' => 479,
                'name' => 'район СП Киевский',
                'slug' => 'rayon-sp-kievskiy-2',
                'city_id' => 12,
            ),
            475 => 
            array (
                'id' => 480,
                'name' => 'район СП Клёновское',
                'slug' => 'rayon-sp-klenovskoe-2',
                'city_id' => 12,
            ),
            476 => 
            array (
                'id' => 481,
                'name' => 'район СП Краснопахорское',
                'slug' => 'rayon-sp-krasnopahorskoe-2',
                'city_id' => 12,
            ),
            477 => 
            array (
                'id' => 482,
                'name' => 'район СП Михайлово-Ярцевское',
                'slug' => 'rayon-sp-mihaylovo-yarcevskoe-2',
                'city_id' => 12,
            ),
            478 => 
            array (
                'id' => 483,
                'name' => 'район СП Новофёдоровское',
                'slug' => 'rayon-sp-novofedorovskoe-2',
                'city_id' => 12,
            ),
            479 => 
            array (
                'id' => 484,
                'name' => 'район СП Первомайское',
                'slug' => 'rayon-sp-pervomayskoe-2',
                'city_id' => 12,
            ),
            480 => 
            array (
                'id' => 485,
                'name' => 'район СП Роговское',
                'slug' => 'rayon-sp-rogovskoe-2',
                'city_id' => 12,
            ),
            481 => 
            array (
                'id' => 486,
                'name' => 'район ГО Троицк',
                'slug' => 'rayon-go-troick-2',
                'city_id' => 12,
            ),
            482 => 
            array (
                'id' => 487,
                'name' => 'район СП Щаповское',
                'slug' => 'rayon-sp-shchapovskoe-2',
                'city_id' => 12,
            ),
            483 => 
            array (
                'id' => 488,
                'name' => 'Центральный район',
                'slug' => 'centralnyy-rayon-5',
                'city_id' => 13,
            ),
            484 => 
            array (
                'id' => 489,
                'name' => 'Советский район',
                'slug' => 'sovetskiy-rayon-5',
                'city_id' => 13,
            ),
            485 => 
            array (
                'id' => 490,
                'name' => 'Первомайский район',
                'slug' => 'pervomayskiy-rayon-1',
                'city_id' => 13,
            ),
            486 => 
            array (
                'id' => 491,
                'name' => 'Октябрьский район',
                'slug' => 'oktyabrskiy-rayon-2',
                'city_id' => 13,
            ),
            487 => 
            array (
                'id' => 492,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon-4',
                'city_id' => 13,
            ),
            488 => 
            array (
                'id' => 493,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-5',
                'city_id' => 13,
            ),
            489 => 
            array (
                'id' => 494,
                'name' => 'Калининский район',
                'slug' => 'kalininskiy-rayon-1',
                'city_id' => 13,
            ),
            490 => 
            array (
                'id' => 495,
                'name' => 'Заельцовский район',
                'slug' => 'zaelcovskiy-rayon',
                'city_id' => 13,
            ),
            491 => 
            array (
                'id' => 496,
                'name' => 'Железнодорожный район',
                'slug' => 'zheleznodorozhnyy-rayon-3',
                'city_id' => 13,
            ),
            492 => 
            array (
                'id' => 497,
                'name' => 'Дзержинский район',
                'slug' => 'dzerzhinskiy-rayon-1',
                'city_id' => 13,
            ),
            493 => 
            array (
                'id' => 498,
                'name' => 'Центральный район',
                'slug' => 'centralnyy-rayon-6',
                'city_id' => 14,
            ),
            494 => 
            array (
                'id' => 499,
                'name' => 'Советский район',
                'slug' => 'sovetskiy-rayon-6',
                'city_id' => 14,
            ),
            495 => 
            array (
                'id' => 500,
                'name' => 'Октябрьский район',
                'slug' => 'oktyabrskiy-rayon-3',
                'city_id' => 14,
            ),
            496 => 
            array (
                'id' => 501,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon-5',
                'city_id' => 14,
            ),
            497 => 
            array (
                'id' => 502,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-6',
                'city_id' => 14,
            ),
            498 => 
            array (
                'id' => 503,
                'name' => 'Свердловский район',
                'slug' => 'sverdlovskiy-rayon-1',
                'city_id' => 15,
            ),
            499 => 
            array (
                'id' => 504,
                'name' => 'Орджоникидзевский район',
                'slug' => 'ordzhonikidzevskiy-rayon-1',
                'city_id' => 15,
            ),
        ));
        \DB::table('city_districts')->insert(array (
            0 => 
            array (
                'id' => 505,
                'name' => 'район Новые Ляды',
                'slug' => 'rayon-novye-lyady',
                'city_id' => 15,
            ),
            1 => 
            array (
                'id' => 506,
                'name' => 'Мотовилихинский район',
                'slug' => 'motovilihinskiy-rayon',
                'city_id' => 15,
            ),
            2 => 
            array (
                'id' => 507,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon-6',
                'city_id' => 15,
            ),
            3 => 
            array (
                'id' => 508,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-7',
                'city_id' => 15,
            ),
            4 => 
            array (
                'id' => 509,
                'name' => 'Индустриальный район',
                'slug' => 'industrialnyy-rayon',
                'city_id' => 15,
            ),
            5 => 
            array (
                'id' => 510,
                'name' => 'Дзержинский район',
                'slug' => 'dzerzhinskiy-rayon-2',
                'city_id' => 15,
            ),
            6 => 
            array (
                'id' => 511,
                'name' => 'район Арбат',
                'slug' => 'rayon-arbat-3',
                'city_id' => 16,
            ),
            7 => 
            array (
                'id' => 512,
                'name' => 'Басманный район',
                'slug' => 'basmannyy-rayon-3',
                'city_id' => 16,
            ),
            8 => 
            array (
                'id' => 513,
                'name' => 'район Замоскворечье',
                'slug' => 'rayon-zamoskvoreche-3',
                'city_id' => 16,
            ),
            9 => 
            array (
                'id' => 514,
                'name' => 'Красносельский район',
                'slug' => 'krasnoselskiy-rayon-4',
                'city_id' => 16,
            ),
            10 => 
            array (
                'id' => 515,
                'name' => 'Мещанский район',
                'slug' => 'meshchanskiy-rayon-3',
                'city_id' => 16,
            ),
            11 => 
            array (
                'id' => 516,
                'name' => 'Пресненский район',
                'slug' => 'presnenskiy-rayon-3',
                'city_id' => 16,
            ),
            12 => 
            array (
                'id' => 517,
                'name' => 'Таганский район',
                'slug' => 'taganskiy-rayon-3',
                'city_id' => 16,
            ),
            13 => 
            array (
                'id' => 518,
                'name' => 'Тверской район',
                'slug' => 'tverskoy-rayon-3',
                'city_id' => 16,
            ),
            14 => 
            array (
                'id' => 519,
                'name' => 'район Хамовники',
                'slug' => 'rayon-hamovniki-3',
                'city_id' => 16,
            ),
            15 => 
            array (
                'id' => 520,
                'name' => 'район Якиманка',
                'slug' => 'rayon-yakimanka-3',
                'city_id' => 16,
            ),
            16 => 
            array (
                'id' => 521,
                'name' => 'район Аэропорт',
                'slug' => 'rayon-aeroport-3',
                'city_id' => 16,
            ),
            17 => 
            array (
                'id' => 522,
                'name' => 'Беговой район',
                'slug' => 'begovoy-rayon-3',
                'city_id' => 16,
            ),
            18 => 
            array (
                'id' => 523,
                'name' => 'Бескудниковский район',
                'slug' => 'beskudnikovskiy-rayon-3',
                'city_id' => 16,
            ),
            19 => 
            array (
                'id' => 524,
                'name' => 'Войковский район',
                'slug' => 'voykovskiy-rayon-3',
                'city_id' => 16,
            ),
            20 => 
            array (
                'id' => 525,
                'name' => 'район Восточное Дегунино',
                'slug' => 'rayon-vostochnoe-degunino-3',
                'city_id' => 16,
            ),
            21 => 
            array (
                'id' => 526,
                'name' => 'Головинский район',
                'slug' => 'golovinskiy-rayon-3',
                'city_id' => 16,
            ),
            22 => 
            array (
                'id' => 527,
                'name' => 'Дмитровский район',
                'slug' => 'dmitrovskiy-rayon-3',
                'city_id' => 16,
            ),
            23 => 
            array (
                'id' => 528,
                'name' => 'район Западное Дегунино',
                'slug' => 'rayon-zapadnoe-degunino-3',
                'city_id' => 16,
            ),
            24 => 
            array (
                'id' => 529,
                'name' => 'район Коптево',
                'slug' => 'rayon-koptevo-3',
                'city_id' => 16,
            ),
            25 => 
            array (
                'id' => 530,
                'name' => 'Левобережный район',
                'slug' => 'levoberezhnyy-rayon-4',
                'city_id' => 16,
            ),
            26 => 
            array (
                'id' => 531,
                'name' => 'Молжаниновский район',
                'slug' => 'molzhaninovskiy-rayon-3',
                'city_id' => 16,
            ),
            27 => 
            array (
                'id' => 532,
                'name' => 'Савёловский район',
                'slug' => 'savelovskiy-rayon-3',
                'city_id' => 16,
            ),
            28 => 
            array (
                'id' => 533,
                'name' => 'район Сокол',
                'slug' => 'rayon-sokol-3',
                'city_id' => 16,
            ),
            29 => 
            array (
                'id' => 534,
                'name' => 'Тимирязевский район',
                'slug' => 'timiryazevskiy-rayon-3',
                'city_id' => 16,
            ),
            30 => 
            array (
                'id' => 535,
                'name' => 'район Ховрино',
                'slug' => 'rayon-hovrino-3',
                'city_id' => 16,
            ),
            31 => 
            array (
                'id' => 536,
                'name' => 'Хорошёвский район',
                'slug' => 'horoshevskiy-rayon-3',
                'city_id' => 16,
            ),
            32 => 
            array (
                'id' => 537,
                'name' => 'Алексеевский район',
                'slug' => 'alekseevskiy-rayon-3',
                'city_id' => 16,
            ),
            33 => 
            array (
                'id' => 538,
                'name' => 'Алтуфьевский район',
                'slug' => 'altufevskiy-rayon-3',
                'city_id' => 16,
            ),
            34 => 
            array (
                'id' => 539,
                'name' => 'Бабушкинский район',
                'slug' => 'babushkinskiy-rayon-3',
                'city_id' => 16,
            ),
            35 => 
            array (
                'id' => 540,
                'name' => 'район Бибирево',
                'slug' => 'rayon-bibirevo-3',
                'city_id' => 16,
            ),
            36 => 
            array (
                'id' => 541,
                'name' => 'Бутырский район',
                'slug' => 'butyrskiy-rayon-3',
                'city_id' => 16,
            ),
            37 => 
            array (
                'id' => 542,
                'name' => 'район Лианозово',
                'slug' => 'rayon-lianozovo-3',
                'city_id' => 16,
            ),
            38 => 
            array (
                'id' => 543,
                'name' => 'Лосиноостровский район',
                'slug' => 'losinoostrovskiy-rayon-3',
                'city_id' => 16,
            ),
            39 => 
            array (
                'id' => 544,
                'name' => 'район Марфино',
                'slug' => 'rayon-marfino-3',
                'city_id' => 16,
            ),
            40 => 
            array (
                'id' => 545,
                'name' => 'район Марьина Роща',
                'slug' => 'rayon-marina-roshcha-3',
                'city_id' => 16,
            ),
            41 => 
            array (
                'id' => 546,
                'name' => 'Останкинский район',
                'slug' => 'ostankinskiy-rayon-3',
                'city_id' => 16,
            ),
            42 => 
            array (
                'id' => 547,
                'name' => 'район Отрадное',
                'slug' => 'rayon-otradnoe-3',
                'city_id' => 16,
            ),
            43 => 
            array (
                'id' => 548,
                'name' => 'район Ростокино',
                'slug' => 'rayon-rostokino-3',
                'city_id' => 16,
            ),
            44 => 
            array (
                'id' => 549,
                'name' => 'район Свиблово',
                'slug' => 'rayon-sviblovo-3',
                'city_id' => 16,
            ),
            45 => 
            array (
                'id' => 550,
                'name' => 'Северный район',
                'slug' => 'severnyy-rayon-3',
                'city_id' => 16,
            ),
            46 => 
            array (
                'id' => 551,
                'name' => 'район Северное Медведково',
                'slug' => 'rayon-severnoe-medvedkovo-3',
                'city_id' => 16,
            ),
            47 => 
            array (
                'id' => 552,
                'name' => 'район Южное Медведково',
                'slug' => 'rayon-yuzhnoe-medvedkovo-3',
                'city_id' => 16,
            ),
            48 => 
            array (
                'id' => 553,
                'name' => 'Ярославский район',
                'slug' => 'yaroslavskiy-rayon-3',
                'city_id' => 16,
            ),
            49 => 
            array (
                'id' => 554,
                'name' => 'район Богородское',
                'slug' => 'rayon-bogorodskoe-3',
                'city_id' => 16,
            ),
            50 => 
            array (
                'id' => 555,
                'name' => 'район Вешняки',
                'slug' => 'rayon-veshnyaki-3',
                'city_id' => 16,
            ),
            51 => 
            array (
                'id' => 556,
                'name' => 'Восточный район',
                'slug' => 'vostochnyy-rayon-3',
                'city_id' => 16,
            ),
            52 => 
            array (
                'id' => 557,
                'name' => 'район Восточное Измайлово',
                'slug' => 'rayon-vostochnoe-izmaylovo-3',
                'city_id' => 16,
            ),
            53 => 
            array (
                'id' => 558,
                'name' => 'район Гольяново',
                'slug' => 'rayon-golyanovo-3',
                'city_id' => 16,
            ),
            54 => 
            array (
                'id' => 559,
                'name' => 'район Ивановское',
                'slug' => 'rayon-ivanovskoe-3',
                'city_id' => 16,
            ),
            55 => 
            array (
                'id' => 560,
                'name' => 'район Измайлово',
                'slug' => 'rayon-izmaylovo-3',
                'city_id' => 16,
            ),
            56 => 
            array (
                'id' => 561,
                'name' => 'Косино-Ухтомский район',
                'slug' => 'kosino-uhtomskiy-rayon-3',
                'city_id' => 16,
            ),
            57 => 
            array (
                'id' => 562,
                'name' => 'район Метрогородок',
                'slug' => 'rayon-metrogorodok-3',
                'city_id' => 16,
            ),
            58 => 
            array (
                'id' => 563,
                'name' => 'район Новогиреево',
                'slug' => 'rayon-novogireevo-3',
                'city_id' => 16,
            ),
            59 => 
            array (
                'id' => 564,
                'name' => 'район Новокосино',
                'slug' => 'rayon-novokosino-3',
                'city_id' => 16,
            ),
            60 => 
            array (
                'id' => 565,
                'name' => 'район Перово',
                'slug' => 'rayon-perovo-3',
                'city_id' => 16,
            ),
            61 => 
            array (
                'id' => 566,
                'name' => 'район Преображенское',
                'slug' => 'rayon-preobrazhenskoe-3',
                'city_id' => 16,
            ),
            62 => 
            array (
                'id' => 567,
                'name' => 'район Северное Измайлово',
                'slug' => 'rayon-severnoe-izmaylovo-3',
                'city_id' => 16,
            ),
            63 => 
            array (
                'id' => 568,
                'name' => 'район Соколиная Гора',
                'slug' => 'rayon-sokolinaya-gora-3',
                'city_id' => 16,
            ),
            64 => 
            array (
                'id' => 569,
                'name' => 'район Сокольники',
                'slug' => 'rayon-sokolniki-3',
                'city_id' => 16,
            ),
            65 => 
            array (
                'id' => 570,
                'name' => 'район Выхино-Жулебино',
                'slug' => 'rayon-vyhino-zhulebino-3',
                'city_id' => 16,
            ),
            66 => 
            array (
                'id' => 571,
                'name' => 'район Капотня',
                'slug' => 'rayon-kapotnya-3',
                'city_id' => 16,
            ),
            67 => 
            array (
                'id' => 572,
                'name' => 'район Кузьминки',
                'slug' => 'rayon-kuzminki-3',
                'city_id' => 16,
            ),
            68 => 
            array (
                'id' => 573,
                'name' => 'район Лефортово',
                'slug' => 'rayon-lefortovo-3',
                'city_id' => 16,
            ),
            69 => 
            array (
                'id' => 574,
                'name' => 'район Люблино',
                'slug' => 'rayon-lyublino-3',
                'city_id' => 16,
            ),
            70 => 
            array (
                'id' => 575,
                'name' => 'район Марьино',
                'slug' => 'rayon-marino-3',
                'city_id' => 16,
            ),
            71 => 
            array (
                'id' => 576,
                'name' => 'район Некрасовка',
                'slug' => 'rayon-nekrasovka-3',
                'city_id' => 16,
            ),
            72 => 
            array (
                'id' => 577,
                'name' => 'Нижегородский район',
                'slug' => 'nizhegorodskiy-rayon-3',
                'city_id' => 16,
            ),
            73 => 
            array (
                'id' => 578,
                'name' => 'район Печатники',
                'slug' => 'rayon-pechatniki-3',
                'city_id' => 16,
            ),
            74 => 
            array (
                'id' => 579,
                'name' => 'Рязанский район',
                'slug' => 'ryazanskiy-rayon-3',
                'city_id' => 16,
            ),
            75 => 
            array (
                'id' => 580,
                'name' => 'район Текстильщики',
                'slug' => 'rayon-tekstilshchiki-3',
                'city_id' => 16,
            ),
            76 => 
            array (
                'id' => 581,
                'name' => 'Южнопортовый район',
                'slug' => 'yuzhnoportovyy-rayon-3',
                'city_id' => 16,
            ),
            77 => 
            array (
                'id' => 582,
                'name' => 'район Бирюлёво Восточное',
                'slug' => 'rayon-biryulevo-vostochnoe-3',
                'city_id' => 16,
            ),
            78 => 
            array (
                'id' => 583,
                'name' => 'район Бирюлёво Западное',
                'slug' => 'rayon-biryulevo-zapadnoe-3',
                'city_id' => 16,
            ),
            79 => 
            array (
                'id' => 584,
                'name' => 'район Братеево',
                'slug' => 'rayon-brateevo-3',
                'city_id' => 16,
            ),
            80 => 
            array (
                'id' => 585,
                'name' => 'Даниловский район',
                'slug' => 'danilovskiy-rayon-3',
                'city_id' => 16,
            ),
            81 => 
            array (
                'id' => 586,
                'name' => 'Донской район',
                'slug' => 'donskoy-rayon-3',
                'city_id' => 16,
            ),
            82 => 
            array (
                'id' => 587,
                'name' => 'район Зябликово',
                'slug' => 'rayon-zyablikovo-3',
                'city_id' => 16,
            ),
            83 => 
            array (
                'id' => 588,
                'name' => 'район Москворечье-Сабурово',
                'slug' => 'rayon-moskvoreche-saburovo-3',
                'city_id' => 16,
            ),
            84 => 
            array (
                'id' => 589,
                'name' => 'район Нагатино-Садовники',
                'slug' => 'rayon-nagatino-sadovniki-3',
                'city_id' => 16,
            ),
            85 => 
            array (
                'id' => 590,
                'name' => 'район Нагатинский Затон',
                'slug' => 'rayon-nagatinskiy-zaton-3',
                'city_id' => 16,
            ),
            86 => 
            array (
                'id' => 591,
                'name' => 'Нагорный район',
                'slug' => 'nagornyy-rayon-3',
                'city_id' => 16,
            ),
            87 => 
            array (
                'id' => 592,
                'name' => 'район Орехово-Борисово Северное',
                'slug' => 'rayon-orehovo-borisovo-severnoe-3',
                'city_id' => 16,
            ),
            88 => 
            array (
                'id' => 593,
                'name' => 'район Орехово-Борисово Южное',
                'slug' => 'rayon-orehovo-borisovo-yuzhnoe-3',
                'city_id' => 16,
            ),
            89 => 
            array (
                'id' => 594,
                'name' => 'район Царицыно',
                'slug' => 'rayon-caricyno-3',
                'city_id' => 16,
            ),
            90 => 
            array (
                'id' => 595,
                'name' => 'район Чертаново Северное',
                'slug' => 'rayon-chertanovo-severnoe-3',
                'city_id' => 16,
            ),
            91 => 
            array (
                'id' => 596,
                'name' => 'район Чертаново Центральное',
                'slug' => 'rayon-chertanovo-centralnoe-3',
                'city_id' => 16,
            ),
            92 => 
            array (
                'id' => 597,
                'name' => 'район Чертаново Южное',
                'slug' => 'rayon-chertanovo-yuzhnoe-3',
                'city_id' => 16,
            ),
            93 => 
            array (
                'id' => 598,
                'name' => 'Академический район',
                'slug' => 'akademicheskiy-rayon-3',
                'city_id' => 16,
            ),
            94 => 
            array (
                'id' => 599,
                'name' => 'Гагаринский район',
                'slug' => 'gagarinskiy-rayon-3',
                'city_id' => 16,
            ),
            95 => 
            array (
                'id' => 600,
                'name' => 'район Зюзино',
                'slug' => 'rayon-zyuzino-3',
                'city_id' => 16,
            ),
            96 => 
            array (
                'id' => 601,
                'name' => 'район Коньково',
                'slug' => 'rayon-konkovo-3',
                'city_id' => 16,
            ),
            97 => 
            array (
                'id' => 602,
                'name' => 'район Котловка',
                'slug' => 'rayon-kotlovka-3',
                'city_id' => 16,
            ),
            98 => 
            array (
                'id' => 603,
                'name' => 'Ломоносовский район',
                'slug' => 'lomonosovskiy-rayon-3',
                'city_id' => 16,
            ),
            99 => 
            array (
                'id' => 604,
                'name' => 'Обручевский район',
                'slug' => 'obruchevskiy-rayon-3',
                'city_id' => 16,
            ),
            100 => 
            array (
                'id' => 605,
                'name' => 'район Северное Бутово',
                'slug' => 'rayon-severnoe-butovo-3',
                'city_id' => 16,
            ),
            101 => 
            array (
                'id' => 606,
                'name' => 'район Тёплый Стан',
                'slug' => 'rayon-teplyy-stan-3',
                'city_id' => 16,
            ),
            102 => 
            array (
                'id' => 607,
                'name' => 'район Черёмушки',
                'slug' => 'rayon-cheremushki-3',
                'city_id' => 16,
            ),
            103 => 
            array (
                'id' => 608,
                'name' => 'район Южное Бутово',
                'slug' => 'rayon-yuzhnoe-butovo-3',
                'city_id' => 16,
            ),
            104 => 
            array (
                'id' => 609,
                'name' => 'район Ясенево',
                'slug' => 'rayon-yasenevo-3',
                'city_id' => 16,
            ),
            105 => 
            array (
                'id' => 610,
                'name' => 'район Дорогомилово',
                'slug' => 'rayon-dorogomilovo-3',
                'city_id' => 16,
            ),
            106 => 
            array (
                'id' => 611,
                'name' => 'район Крылатское',
                'slug' => 'rayon-krylatskoe-3',
                'city_id' => 16,
            ),
            107 => 
            array (
                'id' => 612,
                'name' => 'район Кунцево',
                'slug' => 'rayon-kuncevo-3',
                'city_id' => 16,
            ),
            108 => 
            array (
                'id' => 613,
                'name' => 'Можайский район',
                'slug' => 'mozhayskiy-rayon-3',
                'city_id' => 16,
            ),
            109 => 
            array (
                'id' => 614,
                'name' => 'район Ново-Переделкино',
                'slug' => 'rayon-novo-peredelkino-3',
                'city_id' => 16,
            ),
            110 => 
            array (
                'id' => 615,
                'name' => 'район Очаково-Матвеевское',
                'slug' => 'rayon-ochakovo-matveevskoe-3',
                'city_id' => 16,
            ),
            111 => 
            array (
                'id' => 616,
                'name' => 'район Проспект Вернадского',
                'slug' => 'rayon-prospekt-vernadskogo-3',
                'city_id' => 16,
            ),
            112 => 
            array (
                'id' => 617,
                'name' => 'район Раменки',
                'slug' => 'rayon-ramenki-3',
                'city_id' => 16,
            ),
            113 => 
            array (
                'id' => 618,
                'name' => 'район Солнцево',
                'slug' => 'rayon-solncevo-3',
                'city_id' => 16,
            ),
            114 => 
            array (
                'id' => 619,
                'name' => 'район Тропарёво-Никулино',
                'slug' => 'rayon-troparevo-nikulino-3',
                'city_id' => 16,
            ),
            115 => 
            array (
                'id' => 620,
                'name' => 'район Филёвский Парк',
                'slug' => 'rayon-filevskiy-park-3',
                'city_id' => 16,
            ),
            116 => 
            array (
                'id' => 621,
                'name' => 'район Фили-Давыдково',
                'slug' => 'rayon-fili-davydkovo-3',
                'city_id' => 16,
            ),
            117 => 
            array (
                'id' => 622,
                'name' => 'район Куркино',
                'slug' => 'rayon-kurkino-3',
                'city_id' => 16,
            ),
            118 => 
            array (
                'id' => 623,
                'name' => 'район Митино',
                'slug' => 'rayon-mitino-3',
                'city_id' => 16,
            ),
            119 => 
            array (
                'id' => 624,
                'name' => 'район Покровское-Стрешнево',
                'slug' => 'rayon-pokrovskoe-streshnevo-3',
                'city_id' => 16,
            ),
            120 => 
            array (
                'id' => 625,
                'name' => 'район Северное Тушино',
                'slug' => 'rayon-severnoe-tushino-3',
                'city_id' => 16,
            ),
            121 => 
            array (
                'id' => 626,
                'name' => 'район Хорошёво-Мнёвники',
                'slug' => 'rayon-horoshevo-mnevniki-3',
                'city_id' => 16,
            ),
            122 => 
            array (
                'id' => 627,
                'name' => 'район Щукино',
                'slug' => 'rayon-shchukino-3',
                'city_id' => 16,
            ),
            123 => 
            array (
                'id' => 628,
                'name' => 'район Южное Тушино',
                'slug' => 'rayon-yuzhnoe-tushino-3',
                'city_id' => 16,
            ),
            124 => 
            array (
                'id' => 629,
                'name' => 'район Строгино',
                'slug' => 'rayon-strogino-3',
                'city_id' => 16,
            ),
            125 => 
            array (
                'id' => 630,
                'name' => 'район СП Внуковское',
                'slug' => 'rayon-sp-vnukovskoe-3',
                'city_id' => 16,
            ),
            126 => 
            array (
                'id' => 631,
                'name' => 'район СП Воскресенское',
                'slug' => 'rayon-sp-voskresenskoe-3',
                'city_id' => 16,
            ),
            127 => 
            array (
                'id' => 632,
                'name' => 'район СП Десёновское',
                'slug' => 'rayon-sp-desenovskoe-3',
                'city_id' => 16,
            ),
            128 => 
            array (
                'id' => 633,
                'name' => 'район СП Кокошкино',
                'slug' => 'rayon-sp-kokoshkino-3',
                'city_id' => 16,
            ),
            129 => 
            array (
                'id' => 634,
                'name' => 'район СП Марушкинское',
                'slug' => 'rayon-sp-marushkinskoe-3',
                'city_id' => 16,
            ),
            130 => 
            array (
                'id' => 635,
                'name' => 'район СП Московский',
                'slug' => 'rayon-sp-moskovskiy-3',
                'city_id' => 16,
            ),
            131 => 
            array (
                'id' => 636,
                'name' => 'район СП Мосрентген',
                'slug' => 'rayon-sp-mosrentgen-3',
                'city_id' => 16,
            ),
            132 => 
            array (
                'id' => 637,
                'name' => 'район СП Рязановское',
                'slug' => 'rayon-sp-ryazanovskoe-3',
                'city_id' => 16,
            ),
            133 => 
            array (
                'id' => 638,
                'name' => 'район СП Сосенское',
                'slug' => 'rayon-sp-sosenskoe-3',
                'city_id' => 16,
            ),
            134 => 
            array (
                'id' => 639,
                'name' => 'район СП Филимонковское',
                'slug' => 'rayon-sp-filimonkovskoe-3',
                'city_id' => 16,
            ),
            135 => 
            array (
                'id' => 640,
                'name' => 'район ГО Щербинка',
                'slug' => 'rayon-go-shcherbinka-3',
                'city_id' => 16,
            ),
            136 => 
            array (
                'id' => 641,
                'name' => 'район СП Вороновское',
                'slug' => 'rayon-sp-voronovskoe-3',
                'city_id' => 16,
            ),
            137 => 
            array (
                'id' => 642,
                'name' => 'район СП Киевский',
                'slug' => 'rayon-sp-kievskiy-3',
                'city_id' => 16,
            ),
            138 => 
            array (
                'id' => 643,
                'name' => 'район СП Клёновское',
                'slug' => 'rayon-sp-klenovskoe-3',
                'city_id' => 16,
            ),
            139 => 
            array (
                'id' => 644,
                'name' => 'район СП Краснопахорское',
                'slug' => 'rayon-sp-krasnopahorskoe-3',
                'city_id' => 16,
            ),
            140 => 
            array (
                'id' => 645,
                'name' => 'район СП Михайлово-Ярцевское',
                'slug' => 'rayon-sp-mihaylovo-yarcevskoe-3',
                'city_id' => 16,
            ),
            141 => 
            array (
                'id' => 646,
                'name' => 'район СП Новофёдоровское',
                'slug' => 'rayon-sp-novofedorovskoe-3',
                'city_id' => 16,
            ),
            142 => 
            array (
                'id' => 647,
                'name' => 'район СП Первомайское',
                'slug' => 'rayon-sp-pervomayskoe-3',
                'city_id' => 16,
            ),
            143 => 
            array (
                'id' => 648,
                'name' => 'район СП Роговское',
                'slug' => 'rayon-sp-rogovskoe-3',
                'city_id' => 16,
            ),
            144 => 
            array (
                'id' => 649,
                'name' => 'район ГО Троицк',
                'slug' => 'rayon-go-troick-3',
                'city_id' => 16,
            ),
            145 => 
            array (
                'id' => 650,
                'name' => 'район СП Щаповское',
                'slug' => 'rayon-sp-shchapovskoe-3',
                'city_id' => 16,
            ),
            146 => 
            array (
                'id' => 651,
                'name' => 'Советский район',
                'slug' => 'sovetskiy-rayon-7',
                'city_id' => 17,
            ),
            147 => 
            array (
                'id' => 652,
                'name' => 'Самарский район',
                'slug' => 'samarskiy-rayon',
                'city_id' => 17,
            ),
            148 => 
            array (
                'id' => 653,
                'name' => 'Промышленный район',
                'slug' => 'promyshlennyy-rayon',
                'city_id' => 17,
            ),
            149 => 
            array (
                'id' => 654,
                'name' => 'Октябрьский район',
                'slug' => 'oktyabrskiy-rayon-4',
                'city_id' => 17,
            ),
            150 => 
            array (
                'id' => 655,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon-7',
                'city_id' => 17,
            ),
            151 => 
            array (
                'id' => 656,
                'name' => 'Куйбышевский район',
                'slug' => 'kuybyshevskiy-rayon',
                'city_id' => 17,
            ),
            152 => 
            array (
                'id' => 657,
                'name' => 'Красноглинский район',
                'slug' => 'krasnoglinskiy-rayon',
                'city_id' => 17,
            ),
            153 => 
            array (
                'id' => 658,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-8',
                'city_id' => 17,
            ),
            154 => 
            array (
                'id' => 659,
                'name' => 'Железнодорожный район',
                'slug' => 'zheleznodorozhnyy-rayon-4',
                'city_id' => 17,
            ),
            155 => 
            array (
                'id' => 660,
                'name' => 'Фрунзенский район',
                'slug' => 'frunzenskiy-rayon-2',
                'city_id' => 19,
            ),
            156 => 
            array (
                'id' => 661,
                'name' => 'Октябрьский район',
                'slug' => 'oktyabrskiy-rayon-5',
                'city_id' => 19,
            ),
            157 => 
            array (
                'id' => 662,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon-8',
                'city_id' => 19,
            ),
            158 => 
            array (
                'id' => 663,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-9',
                'city_id' => 19,
            ),
            159 => 
            array (
                'id' => 664,
                'name' => 'Заводской район',
                'slug' => 'zavodskoy-rayon',
                'city_id' => 19,
            ),
            160 => 
            array (
                'id' => 665,
                'name' => 'Волжский район',
                'slug' => 'volzhskiy-rayon',
                'city_id' => 19,
            ),
            161 => 
            array (
                'id' => 666,
                'name' => 'район Арбат',
                'slug' => 'rayon-arbat-4',
                'city_id' => 20,
            ),
            162 => 
            array (
                'id' => 667,
                'name' => 'Басманный район',
                'slug' => 'basmannyy-rayon-4',
                'city_id' => 20,
            ),
            163 => 
            array (
                'id' => 668,
                'name' => 'район Замоскворечье',
                'slug' => 'rayon-zamoskvoreche-4',
                'city_id' => 20,
            ),
            164 => 
            array (
                'id' => 669,
                'name' => 'Красносельский район',
                'slug' => 'krasnoselskiy-rayon-5',
                'city_id' => 20,
            ),
            165 => 
            array (
                'id' => 670,
                'name' => 'Мещанский район',
                'slug' => 'meshchanskiy-rayon-4',
                'city_id' => 20,
            ),
            166 => 
            array (
                'id' => 671,
                'name' => 'Пресненский район',
                'slug' => 'presnenskiy-rayon-4',
                'city_id' => 20,
            ),
            167 => 
            array (
                'id' => 672,
                'name' => 'Таганский район',
                'slug' => 'taganskiy-rayon-4',
                'city_id' => 20,
            ),
            168 => 
            array (
                'id' => 673,
                'name' => 'Тверской район',
                'slug' => 'tverskoy-rayon-4',
                'city_id' => 20,
            ),
            169 => 
            array (
                'id' => 674,
                'name' => 'район Хамовники',
                'slug' => 'rayon-hamovniki-4',
                'city_id' => 20,
            ),
            170 => 
            array (
                'id' => 675,
                'name' => 'район Якиманка',
                'slug' => 'rayon-yakimanka-4',
                'city_id' => 20,
            ),
            171 => 
            array (
                'id' => 676,
                'name' => 'район Аэропорт',
                'slug' => 'rayon-aeroport-4',
                'city_id' => 20,
            ),
            172 => 
            array (
                'id' => 677,
                'name' => 'Беговой район',
                'slug' => 'begovoy-rayon-4',
                'city_id' => 20,
            ),
            173 => 
            array (
                'id' => 678,
                'name' => 'Бескудниковский район',
                'slug' => 'beskudnikovskiy-rayon-4',
                'city_id' => 20,
            ),
            174 => 
            array (
                'id' => 679,
                'name' => 'Войковский район',
                'slug' => 'voykovskiy-rayon-4',
                'city_id' => 20,
            ),
            175 => 
            array (
                'id' => 680,
                'name' => 'район Восточное Дегунино',
                'slug' => 'rayon-vostochnoe-degunino-4',
                'city_id' => 20,
            ),
            176 => 
            array (
                'id' => 681,
                'name' => 'Головинский район',
                'slug' => 'golovinskiy-rayon-4',
                'city_id' => 20,
            ),
            177 => 
            array (
                'id' => 682,
                'name' => 'Дмитровский район',
                'slug' => 'dmitrovskiy-rayon-4',
                'city_id' => 20,
            ),
            178 => 
            array (
                'id' => 683,
                'name' => 'район Западное Дегунино',
                'slug' => 'rayon-zapadnoe-degunino-4',
                'city_id' => 20,
            ),
            179 => 
            array (
                'id' => 684,
                'name' => 'район Коптево',
                'slug' => 'rayon-koptevo-4',
                'city_id' => 20,
            ),
            180 => 
            array (
                'id' => 685,
                'name' => 'Левобережный район',
                'slug' => 'levoberezhnyy-rayon-5',
                'city_id' => 20,
            ),
            181 => 
            array (
                'id' => 686,
                'name' => 'Молжаниновский район',
                'slug' => 'molzhaninovskiy-rayon-4',
                'city_id' => 20,
            ),
            182 => 
            array (
                'id' => 687,
                'name' => 'Савёловский район',
                'slug' => 'savelovskiy-rayon-4',
                'city_id' => 20,
            ),
            183 => 
            array (
                'id' => 688,
                'name' => 'район Сокол',
                'slug' => 'rayon-sokol-4',
                'city_id' => 20,
            ),
            184 => 
            array (
                'id' => 689,
                'name' => 'Тимирязевский район',
                'slug' => 'timiryazevskiy-rayon-4',
                'city_id' => 20,
            ),
            185 => 
            array (
                'id' => 690,
                'name' => 'район Ховрино',
                'slug' => 'rayon-hovrino-4',
                'city_id' => 20,
            ),
            186 => 
            array (
                'id' => 691,
                'name' => 'Хорошёвский район',
                'slug' => 'horoshevskiy-rayon-4',
                'city_id' => 20,
            ),
            187 => 
            array (
                'id' => 692,
                'name' => 'Алексеевский район',
                'slug' => 'alekseevskiy-rayon-4',
                'city_id' => 20,
            ),
            188 => 
            array (
                'id' => 693,
                'name' => 'Алтуфьевский район',
                'slug' => 'altufevskiy-rayon-4',
                'city_id' => 20,
            ),
            189 => 
            array (
                'id' => 694,
                'name' => 'Бабушкинский район',
                'slug' => 'babushkinskiy-rayon-4',
                'city_id' => 20,
            ),
            190 => 
            array (
                'id' => 695,
                'name' => 'район Бибирево',
                'slug' => 'rayon-bibirevo-4',
                'city_id' => 20,
            ),
            191 => 
            array (
                'id' => 696,
                'name' => 'Бутырский район',
                'slug' => 'butyrskiy-rayon-4',
                'city_id' => 20,
            ),
            192 => 
            array (
                'id' => 697,
                'name' => 'район Лианозово',
                'slug' => 'rayon-lianozovo-4',
                'city_id' => 20,
            ),
            193 => 
            array (
                'id' => 698,
                'name' => 'Лосиноостровский район',
                'slug' => 'losinoostrovskiy-rayon-4',
                'city_id' => 20,
            ),
            194 => 
            array (
                'id' => 699,
                'name' => 'район Марфино',
                'slug' => 'rayon-marfino-4',
                'city_id' => 20,
            ),
            195 => 
            array (
                'id' => 700,
                'name' => 'район Марьина Роща',
                'slug' => 'rayon-marina-roshcha-4',
                'city_id' => 20,
            ),
            196 => 
            array (
                'id' => 701,
                'name' => 'Останкинский район',
                'slug' => 'ostankinskiy-rayon-4',
                'city_id' => 20,
            ),
            197 => 
            array (
                'id' => 702,
                'name' => 'район Отрадное',
                'slug' => 'rayon-otradnoe-4',
                'city_id' => 20,
            ),
            198 => 
            array (
                'id' => 703,
                'name' => 'район Ростокино',
                'slug' => 'rayon-rostokino-4',
                'city_id' => 20,
            ),
            199 => 
            array (
                'id' => 704,
                'name' => 'район Свиблово',
                'slug' => 'rayon-sviblovo-4',
                'city_id' => 20,
            ),
            200 => 
            array (
                'id' => 705,
                'name' => 'Северный район',
                'slug' => 'severnyy-rayon-4',
                'city_id' => 20,
            ),
            201 => 
            array (
                'id' => 706,
                'name' => 'район Северное Медведково',
                'slug' => 'rayon-severnoe-medvedkovo-4',
                'city_id' => 20,
            ),
            202 => 
            array (
                'id' => 707,
                'name' => 'район Южное Медведково',
                'slug' => 'rayon-yuzhnoe-medvedkovo-4',
                'city_id' => 20,
            ),
            203 => 
            array (
                'id' => 708,
                'name' => 'Ярославский район',
                'slug' => 'yaroslavskiy-rayon-4',
                'city_id' => 20,
            ),
            204 => 
            array (
                'id' => 709,
                'name' => 'район Богородское',
                'slug' => 'rayon-bogorodskoe-4',
                'city_id' => 20,
            ),
            205 => 
            array (
                'id' => 710,
                'name' => 'район Вешняки',
                'slug' => 'rayon-veshnyaki-4',
                'city_id' => 20,
            ),
            206 => 
            array (
                'id' => 711,
                'name' => 'Восточный район',
                'slug' => 'vostochnyy-rayon-4',
                'city_id' => 20,
            ),
            207 => 
            array (
                'id' => 712,
                'name' => 'район Восточное Измайлово',
                'slug' => 'rayon-vostochnoe-izmaylovo-4',
                'city_id' => 20,
            ),
            208 => 
            array (
                'id' => 713,
                'name' => 'район Гольяново',
                'slug' => 'rayon-golyanovo-4',
                'city_id' => 20,
            ),
            209 => 
            array (
                'id' => 714,
                'name' => 'район Ивановское',
                'slug' => 'rayon-ivanovskoe-4',
                'city_id' => 20,
            ),
            210 => 
            array (
                'id' => 715,
                'name' => 'район Измайлово',
                'slug' => 'rayon-izmaylovo-4',
                'city_id' => 20,
            ),
            211 => 
            array (
                'id' => 716,
                'name' => 'Косино-Ухтомский район',
                'slug' => 'kosino-uhtomskiy-rayon-4',
                'city_id' => 20,
            ),
            212 => 
            array (
                'id' => 717,
                'name' => 'район Метрогородок',
                'slug' => 'rayon-metrogorodok-4',
                'city_id' => 20,
            ),
            213 => 
            array (
                'id' => 718,
                'name' => 'район Новогиреево',
                'slug' => 'rayon-novogireevo-4',
                'city_id' => 20,
            ),
            214 => 
            array (
                'id' => 719,
                'name' => 'район Новокосино',
                'slug' => 'rayon-novokosino-4',
                'city_id' => 20,
            ),
            215 => 
            array (
                'id' => 720,
                'name' => 'район Перово',
                'slug' => 'rayon-perovo-4',
                'city_id' => 20,
            ),
            216 => 
            array (
                'id' => 721,
                'name' => 'район Преображенское',
                'slug' => 'rayon-preobrazhenskoe-4',
                'city_id' => 20,
            ),
            217 => 
            array (
                'id' => 722,
                'name' => 'район Северное Измайлово',
                'slug' => 'rayon-severnoe-izmaylovo-4',
                'city_id' => 20,
            ),
            218 => 
            array (
                'id' => 723,
                'name' => 'район Соколиная Гора',
                'slug' => 'rayon-sokolinaya-gora-4',
                'city_id' => 20,
            ),
            219 => 
            array (
                'id' => 724,
                'name' => 'район Сокольники',
                'slug' => 'rayon-sokolniki-4',
                'city_id' => 20,
            ),
            220 => 
            array (
                'id' => 725,
                'name' => 'район Выхино-Жулебино',
                'slug' => 'rayon-vyhino-zhulebino-4',
                'city_id' => 20,
            ),
            221 => 
            array (
                'id' => 726,
                'name' => 'район Капотня',
                'slug' => 'rayon-kapotnya-4',
                'city_id' => 20,
            ),
            222 => 
            array (
                'id' => 727,
                'name' => 'район Кузьминки',
                'slug' => 'rayon-kuzminki-4',
                'city_id' => 20,
            ),
            223 => 
            array (
                'id' => 728,
                'name' => 'район Лефортово',
                'slug' => 'rayon-lefortovo-4',
                'city_id' => 20,
            ),
            224 => 
            array (
                'id' => 729,
                'name' => 'район Люблино',
                'slug' => 'rayon-lyublino-4',
                'city_id' => 20,
            ),
            225 => 
            array (
                'id' => 730,
                'name' => 'район Марьино',
                'slug' => 'rayon-marino-4',
                'city_id' => 20,
            ),
            226 => 
            array (
                'id' => 731,
                'name' => 'район Некрасовка',
                'slug' => 'rayon-nekrasovka-4',
                'city_id' => 20,
            ),
            227 => 
            array (
                'id' => 732,
                'name' => 'Нижегородский район',
                'slug' => 'nizhegorodskiy-rayon-4',
                'city_id' => 20,
            ),
            228 => 
            array (
                'id' => 733,
                'name' => 'район Печатники',
                'slug' => 'rayon-pechatniki-4',
                'city_id' => 20,
            ),
            229 => 
            array (
                'id' => 734,
                'name' => 'Рязанский район',
                'slug' => 'ryazanskiy-rayon-4',
                'city_id' => 20,
            ),
            230 => 
            array (
                'id' => 735,
                'name' => 'район Текстильщики',
                'slug' => 'rayon-tekstilshchiki-4',
                'city_id' => 20,
            ),
            231 => 
            array (
                'id' => 736,
                'name' => 'Южнопортовый район',
                'slug' => 'yuzhnoportovyy-rayon-4',
                'city_id' => 20,
            ),
            232 => 
            array (
                'id' => 737,
                'name' => 'район Бирюлёво Восточное',
                'slug' => 'rayon-biryulevo-vostochnoe-4',
                'city_id' => 20,
            ),
            233 => 
            array (
                'id' => 738,
                'name' => 'район Бирюлёво Западное',
                'slug' => 'rayon-biryulevo-zapadnoe-4',
                'city_id' => 20,
            ),
            234 => 
            array (
                'id' => 739,
                'name' => 'район Братеево',
                'slug' => 'rayon-brateevo-4',
                'city_id' => 20,
            ),
            235 => 
            array (
                'id' => 740,
                'name' => 'Даниловский район',
                'slug' => 'danilovskiy-rayon-4',
                'city_id' => 20,
            ),
            236 => 
            array (
                'id' => 741,
                'name' => 'Донской район',
                'slug' => 'donskoy-rayon-4',
                'city_id' => 20,
            ),
            237 => 
            array (
                'id' => 742,
                'name' => 'район Зябликово',
                'slug' => 'rayon-zyablikovo-4',
                'city_id' => 20,
            ),
            238 => 
            array (
                'id' => 743,
                'name' => 'район Москворечье-Сабурово',
                'slug' => 'rayon-moskvoreche-saburovo-4',
                'city_id' => 20,
            ),
            239 => 
            array (
                'id' => 744,
                'name' => 'район Нагатино-Садовники',
                'slug' => 'rayon-nagatino-sadovniki-4',
                'city_id' => 20,
            ),
            240 => 
            array (
                'id' => 745,
                'name' => 'район Нагатинский Затон',
                'slug' => 'rayon-nagatinskiy-zaton-4',
                'city_id' => 20,
            ),
            241 => 
            array (
                'id' => 746,
                'name' => 'Нагорный район',
                'slug' => 'nagornyy-rayon-4',
                'city_id' => 20,
            ),
            242 => 
            array (
                'id' => 747,
                'name' => 'район Орехово-Борисово Северное',
                'slug' => 'rayon-orehovo-borisovo-severnoe-4',
                'city_id' => 20,
            ),
            243 => 
            array (
                'id' => 748,
                'name' => 'район Орехово-Борисово Южное',
                'slug' => 'rayon-orehovo-borisovo-yuzhnoe-4',
                'city_id' => 20,
            ),
            244 => 
            array (
                'id' => 749,
                'name' => 'район Царицыно',
                'slug' => 'rayon-caricyno-4',
                'city_id' => 20,
            ),
            245 => 
            array (
                'id' => 750,
                'name' => 'район Чертаново Северное',
                'slug' => 'rayon-chertanovo-severnoe-4',
                'city_id' => 20,
            ),
            246 => 
            array (
                'id' => 751,
                'name' => 'район Чертаново Центральное',
                'slug' => 'rayon-chertanovo-centralnoe-4',
                'city_id' => 20,
            ),
            247 => 
            array (
                'id' => 752,
                'name' => 'район Чертаново Южное',
                'slug' => 'rayon-chertanovo-yuzhnoe-4',
                'city_id' => 20,
            ),
            248 => 
            array (
                'id' => 753,
                'name' => 'Академический район',
                'slug' => 'akademicheskiy-rayon-4',
                'city_id' => 20,
            ),
            249 => 
            array (
                'id' => 754,
                'name' => 'Гагаринский район',
                'slug' => 'gagarinskiy-rayon-4',
                'city_id' => 20,
            ),
            250 => 
            array (
                'id' => 755,
                'name' => 'район Зюзино',
                'slug' => 'rayon-zyuzino-4',
                'city_id' => 20,
            ),
            251 => 
            array (
                'id' => 756,
                'name' => 'район Коньково',
                'slug' => 'rayon-konkovo-4',
                'city_id' => 20,
            ),
            252 => 
            array (
                'id' => 757,
                'name' => 'район Котловка',
                'slug' => 'rayon-kotlovka-4',
                'city_id' => 20,
            ),
            253 => 
            array (
                'id' => 758,
                'name' => 'Ломоносовский район',
                'slug' => 'lomonosovskiy-rayon-4',
                'city_id' => 20,
            ),
            254 => 
            array (
                'id' => 759,
                'name' => 'Обручевский район',
                'slug' => 'obruchevskiy-rayon-4',
                'city_id' => 20,
            ),
            255 => 
            array (
                'id' => 760,
                'name' => 'район Северное Бутово',
                'slug' => 'rayon-severnoe-butovo-4',
                'city_id' => 20,
            ),
            256 => 
            array (
                'id' => 761,
                'name' => 'район Тёплый Стан',
                'slug' => 'rayon-teplyy-stan-4',
                'city_id' => 20,
            ),
            257 => 
            array (
                'id' => 762,
                'name' => 'район Черёмушки',
                'slug' => 'rayon-cheremushki-4',
                'city_id' => 20,
            ),
            258 => 
            array (
                'id' => 763,
                'name' => 'район Южное Бутово',
                'slug' => 'rayon-yuzhnoe-butovo-4',
                'city_id' => 20,
            ),
            259 => 
            array (
                'id' => 764,
                'name' => 'район Ясенево',
                'slug' => 'rayon-yasenevo-4',
                'city_id' => 20,
            ),
            260 => 
            array (
                'id' => 765,
                'name' => 'район Дорогомилово',
                'slug' => 'rayon-dorogomilovo-4',
                'city_id' => 20,
            ),
            261 => 
            array (
                'id' => 766,
                'name' => 'район Крылатское',
                'slug' => 'rayon-krylatskoe-4',
                'city_id' => 20,
            ),
            262 => 
            array (
                'id' => 767,
                'name' => 'район Кунцево',
                'slug' => 'rayon-kuncevo-4',
                'city_id' => 20,
            ),
            263 => 
            array (
                'id' => 768,
                'name' => 'Можайский район',
                'slug' => 'mozhayskiy-rayon-4',
                'city_id' => 20,
            ),
            264 => 
            array (
                'id' => 769,
                'name' => 'район Ново-Переделкино',
                'slug' => 'rayon-novo-peredelkino-4',
                'city_id' => 20,
            ),
            265 => 
            array (
                'id' => 770,
                'name' => 'район Очаково-Матвеевское',
                'slug' => 'rayon-ochakovo-matveevskoe-4',
                'city_id' => 20,
            ),
            266 => 
            array (
                'id' => 771,
                'name' => 'район Проспект Вернадского',
                'slug' => 'rayon-prospekt-vernadskogo-4',
                'city_id' => 20,
            ),
            267 => 
            array (
                'id' => 772,
                'name' => 'район Раменки',
                'slug' => 'rayon-ramenki-4',
                'city_id' => 20,
            ),
            268 => 
            array (
                'id' => 773,
                'name' => 'район Солнцево',
                'slug' => 'rayon-solncevo-4',
                'city_id' => 20,
            ),
            269 => 
            array (
                'id' => 774,
                'name' => 'район Тропарёво-Никулино',
                'slug' => 'rayon-troparevo-nikulino-4',
                'city_id' => 20,
            ),
            270 => 
            array (
                'id' => 775,
                'name' => 'район Филёвский Парк',
                'slug' => 'rayon-filevskiy-park-4',
                'city_id' => 20,
            ),
            271 => 
            array (
                'id' => 776,
                'name' => 'район Фили-Давыдково',
                'slug' => 'rayon-fili-davydkovo-4',
                'city_id' => 20,
            ),
            272 => 
            array (
                'id' => 777,
                'name' => 'район Куркино',
                'slug' => 'rayon-kurkino-4',
                'city_id' => 20,
            ),
            273 => 
            array (
                'id' => 778,
                'name' => 'район Митино',
                'slug' => 'rayon-mitino-4',
                'city_id' => 20,
            ),
            274 => 
            array (
                'id' => 779,
                'name' => 'район Покровское-Стрешнево',
                'slug' => 'rayon-pokrovskoe-streshnevo-4',
                'city_id' => 20,
            ),
            275 => 
            array (
                'id' => 780,
                'name' => 'район Северное Тушино',
                'slug' => 'rayon-severnoe-tushino-4',
                'city_id' => 20,
            ),
            276 => 
            array (
                'id' => 781,
                'name' => 'район Хорошёво-Мнёвники',
                'slug' => 'rayon-horoshevo-mnevniki-4',
                'city_id' => 20,
            ),
            277 => 
            array (
                'id' => 782,
                'name' => 'район Щукино',
                'slug' => 'rayon-shchukino-4',
                'city_id' => 20,
            ),
            278 => 
            array (
                'id' => 783,
                'name' => 'район Южное Тушино',
                'slug' => 'rayon-yuzhnoe-tushino-4',
                'city_id' => 20,
            ),
            279 => 
            array (
                'id' => 784,
                'name' => 'район Строгино',
                'slug' => 'rayon-strogino-4',
                'city_id' => 20,
            ),
            280 => 
            array (
                'id' => 785,
                'name' => 'район СП Внуковское',
                'slug' => 'rayon-sp-vnukovskoe-4',
                'city_id' => 20,
            ),
            281 => 
            array (
                'id' => 786,
                'name' => 'район СП Воскресенское',
                'slug' => 'rayon-sp-voskresenskoe-4',
                'city_id' => 20,
            ),
            282 => 
            array (
                'id' => 787,
                'name' => 'район СП Десёновское',
                'slug' => 'rayon-sp-desenovskoe-4',
                'city_id' => 20,
            ),
            283 => 
            array (
                'id' => 788,
                'name' => 'район СП Кокошкино',
                'slug' => 'rayon-sp-kokoshkino-4',
                'city_id' => 20,
            ),
            284 => 
            array (
                'id' => 789,
                'name' => 'район СП Марушкинское',
                'slug' => 'rayon-sp-marushkinskoe-4',
                'city_id' => 20,
            ),
            285 => 
            array (
                'id' => 790,
                'name' => 'район СП Московский',
                'slug' => 'rayon-sp-moskovskiy-4',
                'city_id' => 20,
            ),
            286 => 
            array (
                'id' => 791,
                'name' => 'район СП Мосрентген',
                'slug' => 'rayon-sp-mosrentgen-4',
                'city_id' => 20,
            ),
            287 => 
            array (
                'id' => 792,
                'name' => 'район СП Рязановское',
                'slug' => 'rayon-sp-ryazanovskoe-4',
                'city_id' => 20,
            ),
            288 => 
            array (
                'id' => 793,
                'name' => 'район СП Сосенское',
                'slug' => 'rayon-sp-sosenskoe-4',
                'city_id' => 20,
            ),
            289 => 
            array (
                'id' => 794,
                'name' => 'район СП Филимонковское',
                'slug' => 'rayon-sp-filimonkovskoe-4',
                'city_id' => 20,
            ),
            290 => 
            array (
                'id' => 795,
                'name' => 'район ГО Щербинка',
                'slug' => 'rayon-go-shcherbinka-4',
                'city_id' => 20,
            ),
            291 => 
            array (
                'id' => 796,
                'name' => 'район СП Вороновское',
                'slug' => 'rayon-sp-voronovskoe-4',
                'city_id' => 20,
            ),
            292 => 
            array (
                'id' => 797,
                'name' => 'район СП Киевский',
                'slug' => 'rayon-sp-kievskiy-4',
                'city_id' => 20,
            ),
            293 => 
            array (
                'id' => 798,
                'name' => 'район СП Клёновское',
                'slug' => 'rayon-sp-klenovskoe-4',
                'city_id' => 20,
            ),
            294 => 
            array (
                'id' => 799,
                'name' => 'район СП Краснопахорское',
                'slug' => 'rayon-sp-krasnopahorskoe-4',
                'city_id' => 20,
            ),
            295 => 
            array (
                'id' => 800,
                'name' => 'район СП Михайлово-Ярцевское',
                'slug' => 'rayon-sp-mihaylovo-yarcevskoe-4',
                'city_id' => 20,
            ),
            296 => 
            array (
                'id' => 801,
                'name' => 'район СП Новофёдоровское',
                'slug' => 'rayon-sp-novofedorovskoe-4',
                'city_id' => 20,
            ),
            297 => 
            array (
                'id' => 802,
                'name' => 'район СП Первомайское',
                'slug' => 'rayon-sp-pervomayskoe-4',
                'city_id' => 20,
            ),
            298 => 
            array (
                'id' => 803,
                'name' => 'район СП Роговское',
                'slug' => 'rayon-sp-rogovskoe-4',
                'city_id' => 20,
            ),
            299 => 
            array (
                'id' => 804,
                'name' => 'район ГО Троицк',
                'slug' => 'rayon-go-troick-4',
                'city_id' => 20,
            ),
            300 => 
            array (
                'id' => 805,
                'name' => 'район СП Щаповское',
                'slug' => 'rayon-sp-shchapovskoe-4',
                'city_id' => 20,
            ),
            301 => 
            array (
                'id' => 806,
                'name' => 'Советский район',
                'slug' => 'sovetskiy-rayon-8',
                'city_id' => 21,
            ),
            302 => 
            array (
                'id' => 807,
                'name' => 'Орджоникидзевский',
                'slug' => 'ordzhonikidzevskiy',
                'city_id' => 21,
            ),
            303 => 
            array (
                'id' => 808,
                'name' => 'Октябрьский район',
                'slug' => 'oktyabrskiy-rayon-6',
                'city_id' => 21,
            ),
            304 => 
            array (
                'id' => 809,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon-9',
                'city_id' => 21,
            ),
            305 => 
            array (
                'id' => 810,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-10',
                'city_id' => 21,
            ),
            306 => 
            array (
                'id' => 811,
                'name' => 'Калининский район',
                'slug' => 'kalininskiy-rayon-2',
                'city_id' => 21,
            ),
            307 => 
            array (
                'id' => 812,
                'name' => 'Дёмский район',
                'slug' => 'demskiy-rayon',
                'city_id' => 21,
            ),
            308 => 
            array (
                'id' => 813,
                'name' => 'Центральный район',
                'slug' => 'centralnyy-rayon-7',
                'city_id' => 22,
            ),
            309 => 
            array (
                'id' => 814,
                'name' => 'Краснофлотский район',
                'slug' => 'krasnoflotskiy-rayon',
                'city_id' => 22,
            ),
            310 => 
            array (
                'id' => 815,
                'name' => 'Кировский район',
                'slug' => 'kirovskiy-rayon-11',
                'city_id' => 22,
            ),
            311 => 
            array (
                'id' => 816,
                'name' => 'Индустриальный район',
                'slug' => 'industrialnyy-rayon-1',
                'city_id' => 22,
            ),
            312 => 
            array (
                'id' => 817,
                'name' => 'Железнодорожный район',
                'slug' => 'zheleznodorozhnyy-rayon-5',
                'city_id' => 22,
            ),
            313 => 
            array (
                'id' => 818,
                'name' => 'Центральный район',
                'slug' => 'centralnyy-rayon-8',
                'city_id' => 23,
            ),
            314 => 
            array (
                'id' => 819,
                'name' => 'Тракторозаводский район',
                'slug' => 'traktorozavodskiy-rayon-1',
                'city_id' => 23,
            ),
            315 => 
            array (
                'id' => 820,
                'name' => 'Советский район',
                'slug' => 'sovetskiy-rayon-9',
                'city_id' => 23,
            ),
            316 => 
            array (
                'id' => 821,
                'name' => 'Металлургический район',
                'slug' => 'metallurgicheskiy-rayon',
                'city_id' => 23,
            ),
            317 => 
            array (
                'id' => 822,
                'name' => 'Ленинский район',
                'slug' => 'leninskiy-rayon-10',
                'city_id' => 23,
            ),
            318 => 
            array (
                'id' => 823,
                'name' => 'Курчатовский район',
                'slug' => 'kurchatovskiy-rayon',
                'city_id' => 23,
            ),
            319 => 
            array (
                'id' => 824,
                'name' => 'Калининский район',
                'slug' => 'kalininskiy-rayon-3',
                'city_id' => 23,
            ),
            320 => 
            array (
                'id' => 825,
                'name' => '1121212',
                'slug' => '211212',
                'city_id' => 4,
            ),
        ));
        
        
    }
}