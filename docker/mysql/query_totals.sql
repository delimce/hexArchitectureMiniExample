SELECT
	sum( payment.amount ) AS total
FROM
	subscriber
	INNER JOIN payment ON subscriber.id = payment.subscriber_id 
WHERE
	subscriber.id = @ID_SUBSCRIBER 
	AND DATE(payment.transaction_date) <= DATE_SUB( subscriber.unsubscribed_at, INTERVAL 1 MONTH );