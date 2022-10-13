using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CArea
    {
        public List<EArea> Listar_Area(SqlConnection con)
        {
            List<EArea> lEArea = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_AREA", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEArea = new List<EArea>();

                EArea obEArea = null;
                while (drd.Read())
                {
                    obEArea = new EArea();
                    obEArea.i_id = drd["i_id"].ToString();
                    obEArea.v_descripcion = drd["v_descripcion"].ToString();
                    lEArea.Add(obEArea);
                }
                drd.Close();
            }

            return (lEArea);
        }
    }
}