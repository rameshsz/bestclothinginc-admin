USE [BestClothing]
GO
/****** Object:  StoredProcedure [dbo].[getFeatured]    Script Date: 4/27/2022 10:12:03 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[getFeatured]  

AS    
    SET NOCOUNT ON;

    SELECT *  
    FROM products   
    RETURN;
GO
