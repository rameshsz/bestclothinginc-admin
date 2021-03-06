USE [BestClothing]
GO
/****** Object:  UserDefinedFunction [dbo].[DupUser]    Script Date: 4/27/2022 10:01:32 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE FUNCTION [dbo].[DupUser] (
	@username varchar(50),
	@email varchar(50)
)
RETURNS varchar(5) AS
BEGIN
	DECLARE @return_value varchar(5);
	SET @return_value = 'test';
    IF EXISTS (SELECT * FROM customers WHERE @email=email) SET @return_value = 'email';
    ELSE IF EXISTS (SELECT * FROM customers WHERE @username=username) SET @return_value = 'user';
	else set @return_value='none'
    RETURN @return_value
END;
GO
