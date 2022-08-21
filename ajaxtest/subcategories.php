<?php
$categories = [
    [
        'id' => 1, 'name' => 'Furniture', 'subcategories' => [
            ['id' => 1, 'name' => 'Beds'],
            ['id' => 2, 'name' => 'Benches']
        ]
    ],
    [
        'id' => 2, 'name' => 'Lighting', 'subcategories' => [
            ['id' => 1, 'name' => 'Ceiling'],
            ['id' => 2, 'name' => 'Floor']
        ]
    ]
];

$category_id = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0;

foreach($categories as $category) {
    if($category['id'] == $category_id) {
        $subcategories = $category['subcategories'];
        foreach($subcategories as $subcategory) {
            echo "<option value=\"{$subcategory['id']}\">";
            echo $subcategory['name'];
            echo "</option>";
        }
    }
}
?>