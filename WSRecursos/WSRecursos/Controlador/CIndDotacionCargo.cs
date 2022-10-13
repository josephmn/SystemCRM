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
    public class CIndDotacionCargo
    {
        public List<EIndDotacionCargo> Listar_IndDotacionCargo(SqlConnection con)
        {
            List<EIndDotacionCargo> lEIndDotacionCargo = null;
            SqlCommand cmd = new SqlCommand("ASP_INDDOTACIONCARGO", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndDotacionCargo = new List<EIndDotacionCargo>();

                EIndDotacionCargo obEIndDotacionCargo = null;
                while (drd.Read())
                {
                    obEIndDotacionCargo = new EIndDotacionCargo();
                    obEIndDotacionCargo.v_area = drd["v_area"].ToString();
                    obEIndDotacionCargo.i_real = drd["i_real"].ToString();
                    obEIndDotacionCargo.i_presupuesto = drd["i_presupuesto"].ToString();
                    obEIndDotacionCargo.i_desviacion = drd["i_desviacion"].ToString();
                    lEIndDotacionCargo.Add(obEIndDotacionCargo);
                }
                drd.Close();
            }

            return (lEIndDotacionCargo);
        }
    }
}