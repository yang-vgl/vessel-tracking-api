# Vessel Tracking API

## Installation

To set up this project, follow the steps below:

1. Pull the code from the repository.
2. Run Docker Compose to start the containers:

   ```bash
   docker-compose up
   ```

3. Access the PHP container:

   ```bash
   docker exec -it vessel-tracking-api_php83 /bin/sh
   ```

4. Inside the PHP container, run Composer to install dependencies:

   ```bash
   composer install
   ```

5. Create env:
   
    ```bash
   cp .env.example .env
   ```
   
6.  Run database migrations:

   ```bash
   php artisan migrate
   ```

   Then, run `php artisan app:import-vessel-positions` to import JSON data.

## API Documentation

### Overview

The Vessel Tracking API provides access to vessel position data based on various filters such as MMSI, latitude and longitude range, and time interval. This documentation outlines the available parameters, their usage, and expected responses.

### Base URL

```
http://localhost/api/vessel-tracking
```

### Request Parameters

#### MMSI
- **Description**: Filter vessels by Maritime Mobile Service Identity (MMSI).
- **Type**: Array of integers
- **Example**: `mmsi[]=247039303`

#### Latitude Range
- **Description**: Filter vessels by latitude range.
- **Type**: Float (decimal degrees)
- **Example**:
   - `min_lat=42.03212`
   - `max_lat=42.75178`

#### Longitude Range
- **Description**: Filter vessels by longitude range.
- **Type**: Float (decimal degrees)
- **Example**:
   - `min_lon=15.4415`
   - `max_lon=16.21578`

#### Time Interval
- **Description**: Filter vessels by a time interval.
- **Type**: Unix timestamp (seconds since epoch)
- **Example**:
   - `start_time=1372683960`
   - `end_time=1372700160`

### Sample Requests

#### JSON

```http
GET /api/vessel-tracking?mmsi[]=247039303&max_lat=42.75178&min_lat=42.03212&max_lon=16.21578&min_lon=15.4415&start_time=1372683960&end_time=1372700160 HTTP/1.1
Host: localhost
Accept: application/json
```

#### XML

```http
GET /api/vessel-tracking?mmsi[]=247039303&max_lat=42.75178&min_lat=42.03212&max_lon=16.21578&min_lon=15.4415&start_time=1372683960&end_time=1372700160 HTTP/1.1
Host: localhost
Accept: application/xml
```

#### CSV

```http
GET /api/vessel-tracking?mmsi[]=247039303&max_lat=42.75178&min_lat=42.03212&max_lon=16.21578&min_lon=15.4415&start_time=1372683960&end_time=1372700160 HTTP/1.1
Host: localhost
Accept: text/csv
```

#### Custom Format

```http
GET /api/vessel-tracking?mmsi[]=247039303&max_lat=42.75178&min_lat=42.03212&max_lon=16.21578&min_lon=15.4415&start_time=1372683960&end_time=1372700160 HTTP/1.1
Host: localhost
Accept: application/vnd.api+json
```

### Response

The API responds with vessel position data in the requested format (JSON, XML, CSV). The response format is determined by the `Accept` header in the request.

### Error Handling

If there are any errors processing the request or retrieving data, the API returns an appropriate HTTP status code along with an error message.

### Rate Limiting

The API enforces rate limiting to prevent abuse. Each user (identified by IP address) is limited to 10 requests per minute.

### Supported Content Types

- **application/json**
- **application/xml**
- **text/csv**
- **application/vnd.api+json**

### Notes

- If latitude and longitude range are provided, vessels within the specified bounding box will be returned.
- Utilize the `halaxa/json-machine` library for stream reading JSON.
- To run tests, execute `./vendor/bin/phpunit`.
- To check coding standards, run `./vendor/bin/phpcs --standard=phpcs.xml .`.



