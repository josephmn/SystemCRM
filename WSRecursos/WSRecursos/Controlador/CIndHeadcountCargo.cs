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
    public class CIndHeadcountCargo
    {
        public List<EIndHeadcountCargo> Listar_IndHeadcountCargo(SqlConnection con)
        {
            List<EIndHeadcountCargo> lEIndHeadcountCargo = null;
            SqlCommand cmd = new SqlCommand("ASP_INDHEADCOUNTCARGO", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndHeadcountCargo = new List<EIndHeadcountCargo>();

                EIndHeadcountCargo obEIndHeadcountCargo = null;
                while (drd.Read())
                {
                    obEIndHeadcountCargo = new EIndHeadcountCargo();
                    obEIndHeadcountCargo.v_area = drd["v_area"].ToString();
                    obEIndHeadcountCargo.i_real = drd["i_real"].ToString();
                    obEIndHeadcountCargo.i_presupuesto = drd["i_presupuesto"].ToString();
                    obEIndHeadcountCargo.i_desviacion = drd["i_desviacion"].ToString();
                    lEIndHeadcountCargo.Add(obEIndHeadcountCargo);
                }
                drd.Close();
            }

            return (lEIndHeadcountCargo);
        }
    }
}