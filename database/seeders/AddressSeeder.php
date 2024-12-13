<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
             // Suburbs with their corresponding postcodes
             $suburbs = [
                ['suburb' => 'Abbotsford', 'post_code' => '2046'],
                ['suburb' => 'Alexandria', 'post_code' => '2015'],
                ['suburb' => 'Annandale', 'post_code' => '2038'],
                ['suburb' => 'Artarmon', 'post_code' => '2064'],
                ['suburb' => 'Ashfield', 'post_code' => '2131'],
                ['suburb' => 'Balmain', 'post_code' => '2041'],
                ['suburb' => 'Balmain East', 'post_code' => '2041'],
                ['suburb' => 'Barangaroo', 'post_code' => '2000'],
                ['suburb' => 'Beaconsfield', 'post_code' => '2015'],
                ['suburb' => 'Bellevue Hill', 'post_code' => '2023'],
                ['suburb' => 'Birchgrove', 'post_code' => '2041'],
                ['suburb' => 'Bondi', 'post_code' => '2026'],
                ['suburb' => 'Bondi Beach', 'post_code' => '2026'],
                ['suburb' => 'Bondi Junction', 'post_code' => '2022'],
                ['suburb' => 'Botany', 'post_code' => '2019'],
                ['suburb' => 'Bronte', 'post_code' => '2024'],
                ['suburb' => 'Cammeray', 'post_code' => '2062'],
                ['suburb' => 'Camperdown', 'post_code' => '2050'],
                ['suburb' => 'Centennial Park', 'post_code' => '2021'],
                ['suburb' => 'Chatswood', 'post_code' => '2067'],
                ['suburb' => 'Chippendale', 'post_code' => '2008'],
                ['suburb' => 'Chiswick', 'post_code' => '2046'],
                ['suburb' => 'Clovelly', 'post_code' => '2031'],
                ['suburb' => 'Coogee', 'post_code' => '2034'],
                ['suburb' => 'Cremorne', 'post_code' => '2090'],
                ['suburb' => 'Cremorne Point', 'post_code' => '2090'],
                ['suburb' => 'Crows Nest', 'post_code' => '2065'],
                ['suburb' => 'Croydon', 'post_code' => '2132'],
                ['suburb' => 'Daceyville', 'post_code' => '2032'],
                ['suburb' => 'Darling Point', 'post_code' => '2027'],
                ['suburb' => 'Darlinghurst', 'post_code' => '2010'],
                ['suburb' => 'Darlington', 'post_code' => '2008'],
                ['suburb' => 'Dawes Point', 'post_code' => '2000'],
                ['suburb' => 'Double Bay', 'post_code' => '2028'],
                ['suburb' => 'Dover Heights', 'post_code' => '2030'],
                ['suburb' => 'Drummoyne', 'post_code' => '2047'],
                ['suburb' => 'Dulwich Hill', 'post_code' => '2203'],
                ['suburb' => 'Eastlakes', 'post_code' => '2018'],
                ['suburb' => 'Edgecliff', 'post_code' => '2027'],
                ['suburb' => 'Elizabeth Bay', 'post_code' => '2011'],
                ['suburb' => 'Enmore', 'post_code' => '2042'],
                ['suburb' => 'Erskineville', 'post_code' => '2043'],
                ['suburb' => 'Eveleigh', 'post_code' => '2015'],
                ['suburb' => 'Five Dock', 'post_code' => '2046'],
                ['suburb' => 'Forest Lodge', 'post_code' => '2037'],
                ['suburb' => 'Glebe', 'post_code' => '2037'],
                ['suburb' => 'Greenwich', 'post_code' => '2065'],
                ['suburb' => 'Haberfield', 'post_code' => '2045'],
                ['suburb' => 'Haymarket', 'post_code' => '2000'],
                ['suburb' => 'Henley', 'post_code' => '2111'],
                ['suburb' => 'Hunters Hill', 'post_code' => '2110'],
                ['suburb' => 'Huntleys Point', 'post_code' => '2111'],
                ['suburb' => 'Kensington', 'post_code' => '2033'],
                ['suburb' => 'Kingsford', 'post_code' => '2032'],
                ['suburb' => 'Kirribilli', 'post_code' => '2061'],
                ['suburb' => 'Kurraba Point', 'post_code' => '2089'],
                ['suburb' => 'Lane Cove', 'post_code' => '2066'],
                ['suburb' => 'Lavender Bay', 'post_code' => '2060'],
                ['suburb' => 'Leichhardt', 'post_code' => '2040'],
                ['suburb' => 'Lewisham', 'post_code' => '2049'],
                ['suburb' => 'Lilyfield', 'post_code' => '2040'],
                ['suburb' => 'Linley Point', 'post_code' => '2066'],
                ['suburb' => 'Longueville', 'post_code' => '2066'],
                ['suburb' => 'Maroubra', 'post_code' => '2035'],
                ['suburb' => 'Marrickville', 'post_code' => '2204'],
                ['suburb' => 'Mascot', 'post_code' => '2020'],
                ['suburb' => 'McMahons Point', 'post_code' => '2060'],
                ['suburb' => 'Millers Point', 'post_code' => '2000'],
                ['suburb' => 'Milsons Point', 'post_code' => '2061'],
                ['suburb' => 'Moore Park', 'post_code' => '2021'],
                ['suburb' => 'Mosman', 'post_code' => '2088'],
                ['suburb' => 'Naremburn', 'post_code' => '2065'],
                ['suburb' => 'Neutral Bay', 'post_code' => '2089'],
                ['suburb' => 'Newtown', 'post_code' => '2042'],
                ['suburb' => 'North Bondi', 'post_code' => '2026'],
                ['suburb' => 'North Sydney', 'post_code' => '2060'],
                ['suburb' => 'Northbridge', 'post_code' => '2063'],
                ['suburb' => 'Northwood', 'post_code' => '2066'],
                ['suburb' => 'Paddington', 'post_code' => '2021'],
                ['suburb' => 'Pagewood', 'post_code' => '2035'],
                ['suburb' => 'Petersham', 'post_code' => '2049'],
                ['suburb' => 'Point Piper', 'post_code' => '2027'],
                ['suburb' => 'Potts Point', 'post_code' => '2011'],
                ['suburb' => 'Pyrmont', 'post_code' => '2009'],
                ['suburb' => 'Queens Park', 'post_code' => '2022'],
                ['suburb' => 'Randwick', 'post_code' => '2031'],
                ['suburb' => 'Redfern', 'post_code' => '2016'],
                ['suburb' => 'Riverview', 'post_code' => '2066'],
                ['suburb' => 'Rodd Point', 'post_code' => '2046'],
                ['suburb' => 'Rose Bay', 'post_code' => '2029'],
                ['suburb' => 'Rosebery', 'post_code' => '2018'],
                ['suburb' => 'Rozelle', 'post_code' => '2039'],
                ['suburb' => 'Rushcutters Bay', 'post_code' => '2011'],
                ['suburb' => 'Russell Lea', 'post_code' => '2046'],
                ['suburb' => 'St Leonards', 'post_code' => '2065'],
                ['suburb' => 'St Peters', 'post_code' => '2044'],
                ['suburb' => 'Stanmore', 'post_code' => '2048'],
                ['suburb' => 'Surry Hills', 'post_code' => '2010'],
                ['suburb' => 'Sydenham', 'post_code' => '2044'],
                ['suburb' => 'Tamarama', 'post_code' => '2026'],
                ['suburb' => 'Tempe', 'post_code' => '2044'],
                ['suburb' => 'The Rocks', 'post_code' => '2000'],
                ['suburb' => 'Ultimo', 'post_code' => '2007'],
                ['suburb' => 'Vaucluse', 'post_code' => '2030'],
                ['suburb' => 'Waterloo', 'post_code' => '2017'],
                ['suburb' => 'Watsons Bay', 'post_code' => '2030'],
                ['suburb' => 'Waverley', 'post_code' => '2024'],
                ['suburb' => 'Waverton', 'post_code' => '2060'],
                ['suburb' => 'Wollstonecraft', 'post_code' => '2065'],
                ['suburb' => 'Woollahra', 'post_code' => '2025'],
                ['suburb' => 'Woolloomooloo', 'post_code' => '2011'],
                ['suburb' => 'Zetland', 'post_code' => '2017'],
            ];

            foreach ($suburbs as $suburb) {
                Address::create([
                    'street' => '',
                    'suburb' => $suburb['suburb'],
                    'post_code' => $suburb['post_code'],
                    'state' => 'NSW', // State of New South Wales
                    'country' => 'Australia',
                ]);
            }


    }
}
