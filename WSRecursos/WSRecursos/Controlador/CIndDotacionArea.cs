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
    public class CIndDotacionArea
    {
        public List<EIndDotacionArea> Listar_IndDotacionArea(SqlConnection con)
        {
            List<EIndDotacionArea> lEIndDotacionArea = null;
            SqlCommand cmd = new SqlCommand("ASP_INDDOTACIONAREA", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndDotacionArea = new List<EIndDotacionArea>();

                EIndDotacionArea obEIndDotacionArea = null;
                while (drd.Read())
                {
                    obEIndDotacionArea = new EIndDotacionArea();
                    obEIndDotacionArea.v_area = drd["v_area"].ToString();
                    obEIndDotacionArea.i_real = drd["i_real"].ToString();
                    obEIndDotacionArea.i_presupuesto = drd["i_presupuesto"].ToString();
                    obEIndDotacionArea.i_desviacion = drd["i_desviacion"].ToString();
                    lEIndDotacionArea.Add(obEIndDotacionArea);
                }
                drd.Close();
            }

            return (lEIndDotacionArea);
        }
    }
}