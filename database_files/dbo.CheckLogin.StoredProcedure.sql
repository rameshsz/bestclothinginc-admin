USE [BestClothing]
GO
/****** Object:  StoredProcedure [dbo].[CheckLogin]    Script Date: 4/27/2022 10:01:32 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[CheckLogin] 
    @username varchar(50)  

AS    
    SET NOCOUNT ON;

    SELECT password  
    FROM customers   
    WHERE username = @username;
    RETURN;
GO
