import datetime
import os
import json
import smtplib
import ssl
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from credentials import password, email

# Read the data.json file to get product names and prices
with open('data.json', 'r') as data_file:
    products = json.load(data_file)

# Create a dictionary to store product prices
product_prices = {product['name']: product['price'] for product in products}

# Define the directory containing apartment JSON files
directory = 'orders/'

# Initialize a dictionary to store product details for all orders
all_products_details = {}

# Initialize variables to store apartment orders and summary HTML
apartment_orders_html = ''
summary_html = '<h2>Gesamte Bestellung</h2>\n'
summary_html += '<table border="1">\n'
summary_html += '<tr><th>Product</th><th>Amount</th><th>Total Price</th></tr>\n'

# Get a list of JSON files in the directory
json_files = [f for f in os.listdir(directory) if f.endswith('.json')]

# Iterate through JSON files in the directory
for filename in json_files:
    apartment_number = os.path.splitext(filename)[0]
    with open(os.path.join(directory, filename), 'r') as apartment_file:
        apartment_order = json.load(apartment_file)
        second_name = apartment_order['name']
        order_items = apartment_order['order']

        # Initialize a dictionary to store product details for the apartment
        product_details = {}

        # Collect product details for the apartment
        for item in order_items:
            product_id = item['id']
            amount = item['amount']
            product_name = next((p['name'] for p in products if p['id'] == product_id), '')
            product_price = product_prices.get(product_name, 0)
            total_price = amount * product_price
            product_details[product_name] = {
                'Amount': amount,
                'Total Price': total_price
            }

        # Collect product details for the summary
        for product_name, details in product_details.items():
            if product_name not in all_products_details:
                all_products_details[product_name] = {
                    'Amount': details['Amount'],
                    'Total Price': details['Total Price']
                }
            else:
                all_products_details[product_name]['Amount'] += details['Amount']
                all_products_details[product_name]['Total Price'] += details['Total Price']

        # Create an HTML table for the individual apartment orders
        apartment_orders_html += f'<h2>[Apartment-{apartment_number}] {second_name}</h2>\n'
        apartment_orders_html += '<table border="1">\n'
        apartment_orders_html += '<tr><th>Bestellung</th><th>Anzahl</th><th>Gesamter Preis</th></tr>\n'

        for product_name, details in product_details.items():
            amount = details['Amount']
            total_price = details['Total Price']
            apartment_orders_html += (
                f'<tr><td>{product_name}</td><td>{amount}</td><td>{total_price:.2f}€</td></tr>\n'
            )

        apartment_orders_html += '</table>\n'

# Create an HTML table for the summary of all ordered products
for product_name, details in all_products_details.items():
    amount = details['Amount']
    total_price = details['Total Price']
    summary_html += (
        f'<tr><td>{product_name}</td><td>{amount}</td><td>{total_price:.2f}€</td></tr>\n'
    )

summary_html += '</table>\n'

# Create the HTML content
html_content = f'''
<!DOCTYPE html>
<html>
<head>
    <title>Apartment Orders</title>
</head>
<body>
    {apartment_orders_html}
    {summary_html}
</body>
</html>
'''

# Define your email configuration
email_sender = email
email_password = password
email_receiver = 'philippsiebenforcher@gmail.com'

subject = "Brotbestellung für den " + str(datetime.date.today())

em = MIMEMultipart()
em['from'] = email_sender
em['to'] = email_receiver
em['subject'] = subject

# Change 'plain' to 'html' to send the email as HTML
em.attach(MIMEText(html_content, 'html'))

context = ssl.create_default_context()

with smtplib.SMTP_SSL('smtp.gmail.com', 465, context=context) as smtp:
    smtp.login(email_sender, email_password)
    smtp.sendmail(email_sender, email_receiver, em.as_string())
