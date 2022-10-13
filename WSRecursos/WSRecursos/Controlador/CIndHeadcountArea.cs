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
    public class CIndHeadcountArea
    {
        public List<EIndHeadcountArea> Listar_IndHeadcountArea(SqlConnection con)
        {
            List<EIndHeadcountArea> lEIndHeadcountArea = null;
            SqlCommand cmd = new SqlCommand("ASP_INDHEADCOUNTAREA", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndHeadcountArea = new List<EIndHeadcountArea>();

                EIndHeadcountArea obEIndHeadcountArea = null;
                while (drd.Read())
                {
                    obEIndHeadcountArea = new EIndHeadcountArea();
                    obEIndHeadcountArea.v_area = drd["v_area"].ToString();
                    obEIndHeadcountArea.i_real = drd["i_real"].ToString();
                    obEIndHeadcountArea.i_presupuesto = drd["i_presupuesto"].ToString();
                    obEIndHeadcountArea.i_desviacion = drd["i_desviacion"].ToString();
                    lEIndHeadcountArea.Add(obEIndHeadcountArea);
                }
                drd.Close();
            }

            return (lEIndHeadcountArea);
        }
    }
}