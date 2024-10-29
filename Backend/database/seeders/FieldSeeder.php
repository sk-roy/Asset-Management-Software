<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    // Land/Flat fields
    private $landFlatAssetFields = [
        ['name' => 'title', 'title' => 'Title', 'type' => 'String'],
        ['name' => 'area', 'title' => 'Area', 'type' => 'Float'],
        ['name' => 'purchase_date', 'title' => 'Purchasing Date', 'type' => 'Date'],
        ['name' => 'purchase_price', 'title' => 'Purchasing Price', 'type' => 'Float'],
        ['name' => 'diagram', 'title' => 'Diagram', 'type' => 'Image'],
        ['name' => 'latitude', 'title' => 'Latitude', 'type' => 'Decimal'],
        ['name' => 'longitude', 'title' => 'Longitude', 'type' => 'Decimal'],
    ];
 
    private $serviceEventFields = [
        ['name' => 'title', 'title' => 'Title', 'type' => 'String'],
        ['name' => 'datetime', 'title' => 'DateTime', 'type' => 'DateTime'],
        ['name' => 'description', 'title' => 'Description', 'type' => 'Text'],
        ['name' => 'charge', 'title' => 'Charge', 'type' => 'Float'],
        ['name' => 'active_mode', 'title' => 'Active Mode', 'type' => 'Boolean'],
        ['name' => 'map_location', 'title' => 'Map Location', 'type' => 'String'],
    ];

    public function run(): void
    {

        $category = Category::where('name', 'Land/Flat')->first();

        foreach ($this->landFlatAssetFields as $fieldData) {
            $field = Field::create($fieldData);
            $field->categories()->attach($category);
        }

        $category = Category::where('name', 'Service')->first();

        foreach ($this->serviceEventFields as $fieldData) {
            $field = Field::create($fieldData);
            $field->categories()->attach($category);
        }
    }
}
