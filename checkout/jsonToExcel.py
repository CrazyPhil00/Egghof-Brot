import os
import json
from openpyxl import Workbook

# Define the product data
products = [
    {
        "id": 1,
        "name": "Dinkelvollkorn Brot",
        "price": 1.80,
        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc porta sagittis sagittis.",
        "image": "img/products/dinkelvollkornbrot.jpg"
    },
    {
        "id": 2,
        "name": "Gerstensonnen Brot",
        "price": 2.00,
        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc porta sagittis sagittis.",
        "image": "img/products/gerstensonnen-brot.jpg"
    },
    {
        "id": 3,
        "name": "Regiopaarl",
        "price": 2.00,
        "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc porta sagittis sagittis.",
        "image": "img/products/regiopaarl.jpg"
    }
]

# Define the directory containing the JSON files
directory = './orders/'

# Iterate through JSON files in the directory
for filename in os.listdir(directory):
    if filename.endswith('.json'):
        # Read the JSON file for each room
        with open(os.path.join(directory, filename), 'r') as file:
            room_data = json.load(file)

        # Create a new Excel workbook
        workbook = Workbook()
        sheet = workbook.active

        # Write headers to the Excel sheet
        sheet['A1'] = 'Room Number'
        sheet['B1'] = 'Name'
        sheet['C1'] = 'Ordered Products'
        sheet['D1'] = 'Total Price'

        # Set room number (name of the JSON file)
        room_number = filename.replace('.json', '')
        sheet['A2'] = room_number

        # Set name (from room_data)
        name = room_data.get('name', '')
        sheet['B2'] = name

        # Set ordered products and their prices
        ordered_products = room_data.get('order', [])
        total_price = 0.0
        for i, product in enumerate(ordered_products):
            product_id = product['id']
            amount = product['amount']
            product_info = next((p for p in products if p['id'] == product_id), None)
            if product_info:
                product_name = product_info['name']
                product_price = product_info['price']
                sheet[f'C{3 + i}'] = f"{product_name} (x{amount})"
                total_price += product_price * amount

        # Set total price
        sheet['D2'] = total_price

        # Save the Excel file
        excel_filename = f"{room_number}_order.xlsx"
        workbook.save(os.path.join(directory, excel_filename))

print("Excel files created successfully.")
